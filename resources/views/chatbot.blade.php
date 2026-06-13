@extends('layouts.app')


@section('title', 'AI Chatbot - Apex Legends Statistics')


@section('styles')
<style>
    :root {
        --primary-color: #f04b23;
        --secondary-color: #293347;
        --background-color: #1a1f2e;
        --card-background: #293347;
        --text-color: #f5f5f5;
        --text-color-2: #CCCCCC;
        --border-color: #333333;
        --success-color: #2ecc71;
        --warning-color: #f39c12;

        /* Typography */
        --font-family: 'Roboto', sans-serif;
        --font-size-xs: 0.75rem;
        --font-size-sm: 0.875rem;
        --font-size-md: 1rem;
        --font-size-lg: 1.25rem;
        --font-size-xl: 1.5rem;
        --font-size-xxl: 2rem;
        --font-size-xxxl: 3rem;

        /* Spacing */
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;

        /* Border radius */
        --border-radius-sm: 30px;
        --border-radius-md: 60px;
        --border-radius-lg: 90px;
        
        /* Shadows */
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeOut {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0px);
      }
    }

    body {
        background: linear-gradient(135deg, rgba(41, 51, 71, 0.9) 0%, rgba(26, 31, 46, 0.95) 100%);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-color: var(--background-color);
        color: var(--text-color);
        font-family: var(--font-family);
    }


    footer {
        margin-top: 1.25rem;
        color: var(--text-color-2);
        font-size: var(--font-size-sm);
        text-align: center;
        margin-bottom: 1rem;
    }


    .back-btn {
        color: var(--text-color);
        text-decoration: none;
        font-size: 1.5rem;
        transition: color 0.3s;
    }

    
    .back-btn:hover {
        color: var(--primary-color);
    }


    .chat-container {
        max-width: 1200px;
        max-height: 90vh;
        margin: 0 auto;
        padding: 20px;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }


    .chat-header {
        text-align: center;
        padding: 20px 0;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 20px;
        animation: fadeOut 0.8s ease-out;
    }


    .chat-header h1 {
        color: var(--primary-color);
        font-size: var(--font-size-xxxl);
        margin-bottom: 10px;
        text-transform: uppercase;
        font-weight: 700;
    }


    .chat-header p {
        font-size: var(--font-size-md);
        text-transform: uppercase;
    }


    .chat-content {
        flex: 1;
        display: flex;
        gap: 20px;
        overflow: hidden;
        animation: fadeIn 0.8s ease-out;
    }


    .chat-main {
        flex: 2;
        background-color: var(--card-background);
        border-radius: var(--border-radius-sm);
        padding: 20px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }


    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 20px;
    }


    .message {
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
    }


    .message.user {
        justify-content: flex-end;
    }


    .message-bubble {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: var(--border-radius-sm);
        line-height: 1.4;
    }


    .message.bot .message-bubble {
        background-color: var(--secondary-color);
        border-top-left-radius: var(--border-radius-sm);
    }


    .message.user .message-bubble {
        background-color: var(--primary-color);
        border-top-right-radius: 4px;
        text-align: right;
    }


    .chat-input {
        display: flex;
        gap: 10px;
    }


    .chat-input input {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: var(--border-radius-sm);
        background-color: var(--background-color);
        color: var(--text-color);
        font-size: 16px;
        outline: none;
    }


    .chat-input button {
        padding: 12px 24px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--border-radius-sm);
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
        overflow: hidden;
        position: relative;
    }

    .chat-input button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.3) 100%);
        transform: translateX(-100%);
        transition: 0.3s;
    }

    .chat-input button:hover::before {
        transform: translateX(0);
    }


    .chat-input button:hover {
        background-color: #c0392b;
    }


    .chat-sidebar {
        flex: 1;
        background-color: var(--card-background);
        border-radius: var(--border-radius-sm);
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }


    .stats-card {
        background-color: var(--background-color);
        border-radius: var(--border-radius-sm);
        padding: 15px;
        margin-bottom: 15px;
        border-left: 4px solid var(--primary-color);
        animation: fadeIn 0.8s ease-out;
    }


    .stats-card h3 {
        margin-top: 0;
        color: var(--primary-color);
    }


    .typing-indicator {
        display: none;
        padding: 10px 0;
        font-style: italic;
        color: #95a5a6;
    }


    .typing-indicator.active {
        display: block;
    }


    .typing-dots span {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #95a5a6;
        margin: 0 2px;
        animation: typing 1.4s infinite;
    }


    .typing-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }


    .typing-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }


    @keyframes typing {
        0%, 60%, 100% {
            transform: translateY(0);
        }
        30% {
            transform: translateY(-10px);
        }
    }


    .suggestion-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 15px;
    }


    .suggestion-chip {
        background-color: var(--background-color);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        padding: 6px 12px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }


    .suggestion-chip:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }


    @media (max-width: 768px) {
        .chat-content {
            flex-direction: column;
        }
        
        .chat-sidebar {
            order: 2;
        }
    }
</style>
@endsection


@section('content')

<div style="position: absolute; top: 1rem; left: 1rem;">
    <a href="{{ route('home') }}" class="back-btn">
        ⮜
    </a>
</div>

<div class="chat-container">
    <div class="chat-header">
        <h1>AI Chatbot</h1>
        <p>Ask me anything about your Apex Legends performance!</p>
    </div>
    
    <div class="chat-content">
        <div class="chat-main">
            <div class="chat-messages" id="chatMessages">
                <div class="message bot">
                    <div class="message-bubble">
                        Hello! I'm your Apex Legends performance assistant. You can ask me about your kills, damage, win rate, and more. Try asking "How's my kill rate?" or "What are my weaknesses?" to get insights based on your gameplay data.
                    </div>
                </div>
            </div>
            
            <div class="typing-indicator" id="typingIndicator">
                <span>AI is typing...</span>
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            
            <div class="chat-input">
                <input type="text" id="messageInput" placeholder="Type your question here..." autocomplete="off">
                <button id="sendButton">Send</button>
            </div>
        </div>
        
        <div style="overflow-y: auto" class="chat-sidebar">
            <div class="stats-card">
                <h3>Today's Stats</h3>
                <p><strong>Total Kills:</strong> <span id="totalKills">-</span></p>
                <p><strong>Total Damage:</strong> <span id="totalDamage">-</span></p>
                <p><strong>Matches Played:</strong> <span id="matchesPlayed">-</span></p>
                <p><strong>Win Rate:</strong> <span id="winRate">-</span></p>
            </div>
            
            <div class="stats-card">
                <h3>Best Performance</h3>
                <p><strong>Highest Kills:</strong> <span id="bestKills">-</span></p>
                <p><strong>Highest Damage:</strong> <span id="bestDamage">-</span></p>
                <p><strong>Best Placement:</strong> <span id="bestPlacement">-</span></p>
            </div>

            <div class="stats-card">
                <h3>Average Performance</h3>
                <p><strong>Average Kills:</strong> <span id="avgKills">-</span></p>
                <p><strong>Average Damage:</strong> <span id="avgDamage">-</span></p>
                <p><strong>Average Placement:</strong> <span id="avgPlacement">-</span></p>
            </div>
            
            <div class="stats-card">
                <h3>Frequently Asked Questions</h3>
                <div class="suggestion-chips">
                    <div class="suggestion-chip" data-question="How's my performance over time?">Performance Over Time</div>
                    <div class="suggestion-chip" data-question="Based on my stats, how can I improve my win rate?">Improving Win Rate</div>
                    <div class="suggestion-chip" data-question="How's my contribution to the team?">Team Contribution</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chatMessages');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const typingIndicator = document.getElementById('typingIndicator');
        

        // Load Apex Legends data from JSON (main & daily summary)
        let apexData = {};
        let dailySummaryLoaded = false;

        // Fetch main stats
        fetch('{{ asset("data/apex_stats_1.json") }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load Apex Legends data');
                }
                return response.json();
            })
            .then(rawData => {
                const playerStats = {
                    totalKills: 0,
                    totalDamage: 0,
                    wins: 0,
                    matches: rawData.length,
                };

                const matchHistory = rawData.map(item => {
                    playerStats.totalKills += item.Kills || 0;
                    playerStats.totalDamage += item['Damage Dealt'] || 0;
                    if (item['Placement'] === 1) {
                        playerStats.wins += 1;
                    }

                    return {
                        kills: item.Kills || 0,
                        damage: item['Damage Dealt'] || 0,
                        placement: item['Placement'] || 0,
                    };
                });

                apexData = {
                    playerStats,
                    matchHistory: matchHistory,
                };

                updateSidebarStats();
            })
            .catch(error => {
                console.error('Error loading data:', error);
            });

        // Fetch daily summary stats
        fetch('{{ asset("data/apex_stats_1_day.json") }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load daily summary data');
                }
                return response.json();
            })
            .then(dayData => {
                apexData.dailySummary = dayData;
                dailySummaryLoaded = true;
            })
            .catch(error => {
                console.error('Error loading daily summary:', error);
            });
        
        function updateSidebarStats() {
            if (apexData.playerStats) {
                document.getElementById('totalKills').textContent = apexData.playerStats.totalKills;
                document.getElementById('totalDamage').textContent = apexData.playerStats.totalDamage.toLocaleString('en-US');
                document.getElementById('matchesPlayed').textContent = apexData.playerStats.matches;
                
                const winRate = ((apexData.playerStats.wins / apexData.playerStats.matches) * 100).toFixed(1);
                document.getElementById('winRate').textContent = winRate + '%';
                
                if (apexData.matchHistory && apexData.matchHistory.length > 0) {
                    const bestKills = Math.max(...apexData.matchHistory.map(m => m.kills));
                    const bestDamage = Math.max(...apexData.matchHistory.map(m => m.damage));
                    const bestPlacement = Math.min(...apexData.matchHistory.map(m => m.placement));
                    
                    document.getElementById('bestKills').textContent = bestKills;
                    document.getElementById('bestDamage').textContent = bestDamage.toLocaleString('en-US');
                    document.getElementById('bestPlacement').textContent = '#' + bestPlacement;


                    const avgKills = (apexData.playerStats.totalKills / apexData.playerStats.matches).toFixed(2);
                    const avgDamage = (apexData.playerStats.totalDamage / apexData.playerStats.matches).toFixed(2);
                    const avgPlacement = (apexData.matchHistory.reduce((sum, m) => sum + m.placement, 0) / apexData.playerStats.matches).toFixed(0);
                    
                    document.getElementById('avgKills').textContent = avgKills;
                    document.getElementById('avgDamage').textContent = avgDamage.toLocaleString('en-US');
                    document.getElementById('avgPlacement').textContent = '#' + avgPlacement;

                }
            }
        }
        
        function addMessage(message, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
            
            const bubbleDiv = document.createElement('div');
            bubbleDiv.className = 'message-bubble';
            bubbleDiv.textContent = message;
            
            messageDiv.appendChild(bubbleDiv);
            chatMessages.appendChild(messageDiv);
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        function showTypingIndicator() {
            typingIndicator.classList.add('active');
        }
        
        function hideTypingIndicator() {
            typingIndicator.classList.remove('active');
        }
        
        async function processUserMessage(message) {
            // Show typing indicator
            showTypingIndicator();

            try {
                const response = await sendToAssistant(message);
                addMessage(response);
            } catch (error) {
                console.error(error);
                addMessage('Sorry, there was an error processing your request. Please try again later.');
            } finally {
                hideTypingIndicator();
            }
        }

        async function sendToAssistant(message) {
            const stats = apexData.playerStats ? {
                totalKills: apexData.playerStats.totalKills,
                totalDamage: apexData.playerStats.totalDamage,
                wins: apexData.playerStats.wins,
                matches: apexData.playerStats.matches,
                avgKills: (apexData.playerStats.totalKills / apexData.playerStats.matches).toFixed(2),
                avgDamage: Math.round(apexData.playerStats.totalDamage / apexData.playerStats.matches),
            } : {};

            if (apexData.matchHistory && apexData.matchHistory.length > 0 && apexData.playerStats) {
                stats.bestKills = Math.max(...apexData.matchHistory.map(m => m.kills));
                stats.bestDamage = Math.max(...apexData.matchHistory.map(m => m.damage));
                stats.bestPlacement = Math.min(...apexData.matchHistory.map(m => m.placement));
                stats.avgPlacement = (apexData.matchHistory.reduce((sum, m) => sum + m.placement, 0) / apexData.playerStats.matches).toFixed(0);
            }

            // // Sertakan daily summary jika sudah dimuat
            // if (apexData.dailySummary) {
            //     stats.dailySummary = apexData.dailySummary;
            // }

            const response = await fetch('{{ route('chatbot.message') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    message,
                    stats,
                }),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                throw new Error(data.message || 'Failed to connect to the AI service.');
            }

            return data.message || 'Sorry, I could not generate a response.';
        }

        // Send message function
        function sendMessage() {
            const message = messageInput.value.trim();
            if (message === '') return;
            
            // Add user message to chat
            addMessage(message, true);
            
            // Clear input
            messageInput.value = '';
            
            // Process message
            processUserMessage(message);
        }
        
        // Event listeners
        sendButton.addEventListener('click', sendMessage);
        
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Suggestion chips
        document.querySelectorAll('.suggestion-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                const question = this.getAttribute('data-question');
                messageInput.value = question;
                sendMessage();
            });
        });
    });
</script>
@endsection