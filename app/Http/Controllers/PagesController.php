<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PagesController extends Controller
{
    public function login(Request $request)
    {
        if ($request->session()->get('logged_in')) {
            return redirect()->route('home');
        }

        return view('login');
    }

    public function home()
    {
        return view('home');
    }

    public function dashboard()
    {
        return view('dashboard', [
            'apexStats1' => $this->loadJsonData('data/apex_stats_1.json'),
            'apexStats2' => $this->loadJsonData('data/apex_stats_2.json'),
        ]);
    }

    public function chatbot()
    {
        return view('chatbot');
    }

    public function chatbotMessage(Request $request)
    {
        // Local models can need more than 30 seconds on CPU for first tokens.
        @set_time_limit(180);

        $request->validate([
            'message' => 'required|string|max:1000',
            'stats' => 'nullable|array',
        ]);

        $stats = $request->input('stats', []);
        $statsDescription = $this->formatStatsForPrompt($stats);

        $baseUrl = rtrim(config('services.ollama.base_url', 'http://127.0.0.1:11434'), '/');
        $model = config('services.ollama.model', 'qwen2.5:7b-instruct');

        if (empty($model)) {
            return response()->json([
                'message' => 'Ollama model is not configured. Please set OLLAMA_MODEL in your environment variables.',
            ], 500);
        }

        $systemPrompt = "You are an Apex Legends performance assistant. Use only the provided player statistics when answering questions about gameplay performance. If the user asks an unrelated question, answer politely that you can only help with Apex Legends performance and statistics.";
        $userPrompt = "Player statistics:\n{$statsDescription}\n\nUser: {$request->input('message')}";

        try {
            $response = Http::timeout(150)->post("{$baseUrl}/api/chat", [
                'model' => $model,
                'stream' => false,
                'options' => [
                    'temperature' => 0.7,
                    'num_predict' => 256,
                ],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt,
                    ],
                    [
                        'role' => 'user',
                        'content' => $userPrompt,
                    ],
                ],
            ]);
        } catch (ConnectionException $e) {
            return response()->json([
                'message' => 'Connection to Ollama failed. Please ensure Ollama is running at http://127.0.0.1:11434 and the model is available.',
            ], 500);
        }

        if ($response->failed()) {
            $apiError = data_get($response->json(), 'error')
                ?? data_get($response->json(), 'message');

            return response()->json([
                'message' => $apiError ?: 'Sorry, I could not connect to Ollama. Please check your local Ollama service and model availability.',
            ], 500);
        }

        $content = $response->json();
        $output = $content['message']['content'] ?? null;

        return response()->json([
            'message' => trim($output ?? 'Sorry, I could not generate a response.'),
        ]);
    }

    protected function formatStatsForPrompt(array $stats): string
    {
        if (empty($stats)) {
            return 'No player statistics were provided.';
        }

        $lines = [];

        foreach ($stats as $key => $value) {
            if (is_array($value)) {
                $jsonValue = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $lines[] = ucfirst(str_replace('_', ' ', (string) $key)) . ': ' . ($jsonValue ?: '[]');
            } else {
                $lines[] = ucfirst(str_replace('_', ' ', (string) $key)) . ': ' . $value;
            }
        }

        return implode("\n", $lines);
    }

    protected function loadJsonData(string $relativePath): array
    {
        $path = public_path($relativePath);

        if (! is_file($path)) {
            abort(500, "Dashboard data file not found: {$relativePath}");
        }

        return json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    }

    public function handlePost(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $allowedUsers = [
            ['username' => 'admin', 'password' => 'password123'],
            ['username' => 'haha', 'password' => 'hihi'],
        ];

        $authenticated = false;
        foreach ($allowedUsers as $user) {
            if ($request->username === $user['username'] && $request->password === $user['password']) {
                $authenticated = true;
                break;
            }
        }

        if ($authenticated) {
            $request->session()->regenerate();
            $request->session()->put('logged_in', true);
            $request->session()->put('username', $request->username);

            return redirect()->route('home')->with('success', 'Login successfully!');
        }

        return back()->with('error', 'Invalid credentials login.')->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['logged_in', 'username']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
