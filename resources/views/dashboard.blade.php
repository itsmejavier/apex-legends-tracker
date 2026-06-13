<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Apex Legends Tracker</title>
  <script src="{{ asset('vendor/vega/vega.min.js') }}"></script>
  <script src="{{ asset('vendor/vega/vega-lite.min.js') }}"></script>
  <script src="{{ asset('vendor/vega/vega-embed.min.js') }}"></script>
  <style>
    /* Global Styles */
    :root {
      /* Color Palette */
      --primary-color: #f04b23; /* Apex Legends Red */
      --background-color: #1a1f2e; /* Apex Legends Dark Blue */
      --accent-color: #ffce00; /* Apex Legends Yellow */
      --dark-color: #1a1f2e;
      --light-color: #f5f5f5;
      --text-color: #333333;
      --border-color: #cccccc;
      --error-color: #e74c3c;
      --success-color: #2ecc71;
      
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


    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }


    body {
      background: linear-gradient(135deg, rgba(41, 51, 71, 0.9) 0%, rgba(26, 31, 46, 0.95) 100%);
      background-repeat: no-repeat;
      background-attachment: fixed;
      font-family: var(--font-family);
      font-size: var(--font-size-base);
      line-height: var(--line-height);
      color: var(--text-color);
      background-color: var(--background-color);
    }


    .back-btn {
        color: var(--light-color);
        text-decoration: none;
        font-size: 1.5rem;
        transition: color 0.3s;
    }


    .back-btn:hover {
        color: var(--primary-color);
    }


    .main-content {
        max-width: 1450px;
        max-height: 90vh;
        margin: 0 auto;
        padding: 20px;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }



    /* Header and Footer */
    .header {
      text-align: center;
      padding: 20px 0;
      border-bottom: 2px solid rgba(255, 255, 255, 0.1);
      margin-bottom: 20px;
      animation: fadeOut 0.8s ease-out;
    }


    .header h1 {
      color: var(--primary-color);
      font-size: var(--font-size-xxxl);
      margin-bottom: 10px;
      text-transform: uppercase;
      font-weight: 700;
    }


    .header p {
      font-size: var(--font-size-md);
      color: var(--light-color);
      text-transform: uppercase;
      margin-bottom: 20px;
    }

    
    footer {
      color: var(--border-color);
      text-align: center;
      padding: 15px;
      margin-top: 20px;
      font-size: var(--font-size-sm);
    }


    /* Dashboard Layout */
    .dashboard {
      padding: 20px;
      max-width: auto;
      margin: 0 auto;
      margin-top: -20px;
    }


    .top-row {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }


    .bottom-row {
      display: flex;
      gap: 20px;
      justify-content: center; /* Centers horizontally */
      align-items: center;     /* Centers vertically */
    }

    /* Chart Containers */
    .chart-container {
      background-color: #293347;
      border-radius: var(--border-radius-sm);
      padding: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      transition: transform 0.2s, box-shadow 0.2s;
      animation: fadeIn 0.8s ease-out;
    }


    .chart-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }


    .chart-container h3 {
      font-size: var(--font-size-md);
      color: var(--primary-color);
      margin-bottom: 15px;
      border-bottom: 2px solid var(--border-color);
      padding-bottom: 10px;
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

    .error-message {
      color: var(--accent-color);
      padding: 15px;
      background-color: rgba(231, 76, 60, 0.1);
      border-radius: var(--border-radius-sm);
      margin-top: 10px;
    }


    /* Loading Spinner */
    .loading {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 200px;
    }


    .spinner {
      width: 50px;
      height: 50px;
      border: 5px solid rgba(0, 0, 0, 0.1);
      border-radius: 50%;
      border-top-color: var(--primary-color);
      animation: spin 1s ease-in-out infinite;
    }


    @keyframes spin {
      to { transform: rotate(360deg); }
    }


    /* Responsive Design */
    @media (max-width: 768px) {
      .top-row {
        grid-template-columns: 1fr;
      }
      
      header h1 {
        font-size: calc(var(--font-size-xl) * 0.8);
      }
    }
  </style>
</head>
<body>
  <div class="main-content">
    <div style="position: absolute; top: 1rem; left: 1rem;">
        <a href="{{ route('home') }}" class="back-btn">
            ⮜
        </a>
    </div>

    <div class="header">
      <h1>Dashboard</h1>
      <p>Review your Apex Legends performance</p>
    </div>
    
    <main class="dashboard">
      <div class="top-row">
        <div id="kills-performance" class="chart-container">
          <div class="loading">
            <div class="spinner"></div>
          </div>
        </div>
        <div id="total-squad-performance" class="chart-container">
          <div class="loading">
            <div class="spinner"></div>
          </div>
        </div>
        <div id="points-damage-relation" class="chart-container">
          <div class="loading">
            <div class="spinner"></div>
          </div>
        </div>
        
      </div>
      
      <div class="bottom-row">
        <div id="kills-differences" class="chart-container">
          <div class="loading">
            <div class="spinner"></div>
          </div>
        </div>
        <!-- <div id="total-squad-performance2" class="chart-container">
          <div class="loading">
            <div class="spinner"></div>
          </div>
        </div>
        <div id="points-damage-relation2" class="chart-container">
          <div class="loading">
            <div class="spinner"></div>
          </div>
        </div> -->
      </div>
      
    </main>
    <footer>
      <p>© 2026 Apex Legends Tracker</p>
    </footer>
  </div>

  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const apex_stats_1 = @json($apexStats1);
      const apex_stats_2 = @json($apexStats2);

      // Function to initialize all charts
      function initializeCharts() {
        // Spesifikasi untuk Kills Performance Over Time
        const killsPerformanceSpec = {
          config: {
            view: { continuousWidth: 300, continuousHeight: 300 },
            background: '#0000',
          },
          data: { values: apex_stats_1 },
          mark: { type: 'bar', cursor: 'pointer', tooltip: true },
          encoding: {
            color: {
              field: 'Damage Dealt',
              title: ['Damage', 'Dealt'],
              legend: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              scale: { scheme: 'orangered' },
              type: 'quantitative',
            },
            x: {
              axis: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              field: 'Record Date',
              type: 'temporal',
            },
            y: {
              axis: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              field: 'Kills',
              type: 'quantitative',
            },
            opacity: {
              condition: {
                test: {
                  and: [
                    { param: 'param_db82be42624d4632' },
                    { param: 'legend_selection_Damage Dealt' },
                    { param: 'select_point' },
                    { param: 'select_interval' },
                  ],
                },
                value: 1,
              },
              value: 0.2,
            },
          },
          params: [
            {
              name: 'param_db82be42624d4632',
              select: { type: 'interval', encodings: ['x'] },
              bind: 'scales',
            },
            {
              name: 'legend_selection_Damage Dealt',
              select: { type: 'point', fields: ['Damage Dealt'] },
              bind: 'legend',
            },
            {
              name: 'select_point',
              select: { type: 'point', on: 'click[!event.metaKey]' },
            },
            {
              name: 'select_interval',
              select: {
                type: 'interval',
                mark: {
                  fill: '#669EFF',
                  fillOpacity: 0.07,
                  stroke: '#669EFF',
                  strokeOpacity: 0.4,
                },
                on: '[mousedown[!event.metaKey], mouseup] > mousemove[!event.metaKey]',
                translate:
                  '[mousedown[!event.metaKey], mouseup] > mousemove[!event.metaKey]',
              },
            },
          ],
          $schema: 'https://vega.github.io/schema/vega-lite/v5.json',
          };

        const totalSquadPerformanceSpec = {
          config: {
            view: { continuousWidth: 300, continuousHeight: 300 },
            background: '#0000',
          },
          data: { values: apex_stats_1 },
          mark: { type: 'bar', cursor: 'pointer', tooltip: true },
          encoding: {
            color: {
              field: 'Placement',
              legend: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              scale: { reverse: true, scheme: 'orangered' },
              type: 'quantitative',
            },
            x: {
              axis: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              field: 'Record Date',
              type: 'temporal',
            },
            y: {
              axis: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              field: 'Total Kills with Squad',
              type: 'quantitative',
            },
            opacity: {
              condition: {
                test: {
                  and: [
                    { param: 'param_db82be42624d4632' },
                    { param: 'legend_selection_Placement' },
                    { param: 'select_point' },
                    { param: 'select_interval' },
                  ],
                },
                value: 1,
              },
              value: 0.2,
            },
          },
          params: [
            {
              name: 'param_db82be42624d4632',
              select: { type: 'interval', encodings: ['x'] },
              bind: 'scales',
            },
            {
              name: 'legend_selection_Placement',
              select: { type: 'point', fields: ['Placement'] },
              bind: 'legend',
            },
            {
              name: 'select_point',
              select: { type: 'point', on: 'click[!event.metaKey]' },
            },
            {
              name: 'select_interval',
              select: {
                type: 'interval',
                mark: {
                  fill: '#669EFF',
                  fillOpacity: 0.07,
                  stroke: '#669EFF',
                  strokeOpacity: 0.4,
                },
                on: '[mousedown[!event.metaKey], mouseup] > mousemove[!event.metaKey]',
                translate:
                  '[mousedown[!event.metaKey], mouseup] > mousemove[!event.metaKey]',
              },
            },
          ],
          $schema: 'https://vega.github.io/schema/vega-lite/v5.json',
        };

        const pointsDamageRelationSpec = {
          config: {
            view: { continuousWidth: 300, continuousHeight: 300 },
            background: '#0000',
          },
          data: { values: apex_stats_1 },
          mark: { type: 'bar', size: 15, cursor: 'pointer', tooltip: true },
          encoding: {
            color: {
              field: 'Damage Dealt',
              title: ['Damage', 'Dealt'],
              legend: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              scale: { scheme: 'orangered' },
              type: 'quantitative',
            },
            x: {
              axis: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              field: 'Points',
              type: 'quantitative',
            },
            y: {
              aggregate: 'count',
              axis: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              type: 'quantitative',
            },
            opacity: {
              condition: {
                test: {
                  and: [
                    { param: 'param_db82be42624d4632' },
                    { param: 'legend_selection_Damage Dealt' },
                    { param: 'select_point' },
                    { param: 'select_interval' },
                  ],
                },
                value: 1,
              },
              value: 0.2,
            },
          },
          params: [
            {
              name: 'param_db82be42624d4632',
              select: { type: 'interval', encodings: ['x'] },
              bind: 'scales',
            },
            {
              name: 'legend_selection_Damage Dealt',
              select: { type: 'point', fields: ['Damage Dealt'] },
              bind: 'legend',
            },
            {
              name: 'select_point',
              select: { type: 'point', encodings: ['x'], on: 'click[!event.metaKey]' },
            },
            {
              name: 'select_interval',
              select: {
                type: 'interval',
                encodings: ['x'],
                mark: {
                  fill: '#669EFF',
                  fillOpacity: 0.07,
                  stroke: '#669EFF',
                  strokeOpacity: 0.4,
                },
                on: '[mousedown[!event.metaKey], mouseup] > mousemove[!event.metaKey]',
                translate:
                  '[mousedown[!event.metaKey], mouseup] > mousemove[!event.metaKey]',
              },
            },
          ],
          $schema: 'https://vega.github.io/schema/vega-lite/v5.json',
        };

        const killsDifferencesSpec = {
          width: 1200,
          config: {
            view: { continuousWidth: 300, continuousHeight: 300 },
            background: '#0000',
          },
          data: { values: apex_stats_2 },
          mark: { type: 'bar' },
          encoding: {
            color: {
              field: 'Type Kills',
              legend: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              scale: { reverse: true, scheme: 'orangered' },
              type: 'nominal',
            },
            opacity: {
              condition: { param: 'param_9735895d3f2ed79c', value: 1 },
              value: 0.05,
            },
            tooltip: [
              { field: 'Record Date', timeUnit: 'yearmonthdate', title: 'Record Date' },
              { field: 'Kills' },
              { field: 'Type Kills' },
            ],
            x: {
              axis: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              field: 'Record Date',
              timeUnit: 'yearmonthdate',
              title: 'Record Date',
              type: 'temporal',
            },
            xOffset: { field: 'Type Kills', type: 'nominal' },
            y: {
              axis: { labelColor: 'var(--border-color)', titleColor: 'var(--border-color)' },
              field: 'Kills',
              stack: false,
              type: 'quantitative',
            },
          },
          params: [
            {
              name: 'param_db82be42624d4632',
              select: { type: 'interval', encodings: ['x'] },
              bind: 'scales',
            },
            {
              name: 'param_9735895d3f2ed79c',
              select: { type: 'point', fields: ['Type Kills'] },
              bind: 'legend',
            },
          ],
          $schema: 'https://vega.github.io/schema/vega-lite/v5.json',
        };


      // Fungsi untuk embed visualisasi dengan error handling
      function embedVisualization(containerId, spec, options = {}) {
        const defaultOptions = {
          actions: false,
          renderer: 'svg',
          theme: 'quartz'
        };
        
        const embedOptions = Object.assign({}, defaultOptions, options);
        
        return vegaEmbed(`#${containerId}`, spec, embedOptions)
          .then(result => {
            // Remove loading spinner after successful embedding
            const container = document.getElementById(containerId);
            const loadingElement = container.querySelector('.loading');
            if (loadingElement) {
              loadingElement.style.display = 'none';
            }
            
            // Add chart title
            const title = document.createElement('h3');
            
            switch(containerId) {
              case 'kills-performance':
                title.textContent = 'Kills Performance Over Time';
                break;
              case 'total-squad-performance':
                title.textContent = 'Total Kills with Squad Performance Over Time';
                break;
              case 'points-damage-relation':
                title.textContent = 'Points–Damage Dealt Relation';
                break;
              case 'kills-differences':
                title.textContent = 'Individual and Squad Kills Differences Over Time';
                break;

                
              // case 'total-squad-performance2':
              //   title.textContent = 'Total Kills with Squad Performance Over Time';
              //   break;
              // case 'points-damage-relation2':
              //   title.textContent = 'Points–Damage Dealt Relation';
              //   break;
            }
            
            container.insertBefore(title, container.firstChild);
            
            return result;
          })
          .catch(error => {
            console.error(`Error rendering ${containerId}:`, error);
            
            const container = document.getElementById(containerId);
            const loadingElement = container.querySelector('.loading');
            if (loadingElement) {
              loadingElement.style.display = 'none';
            }
            
            const errorMessage = document.createElement('div');
            errorMessage.className = 'error-message';
            errorMessage.innerHTML = `
              <p>Failed to load visualization: ${error.message}</p>
              <p>Please refresh the page or check your internet connection.</p>
            `;
            container.appendChild(errorMessage);
            
            throw error;
          });
      }
      
      // Embed semua visualisasi
      embedVisualization('kills-performance', killsPerformanceSpec);
      embedVisualization('total-squad-performance', totalSquadPerformanceSpec);
      embedVisualization('points-damage-relation', pointsDamageRelationSpec);
      embedVisualization('kills-differences', killsDifferencesSpec);

      // embedVisualization('total-squad-performance2', totalSquadPerformanceSpec);
      // embedVisualization('points-damage-relation2', pointsDamageRelationSpec);


      
      // Tambahkan interaktivitas untuk hover effects
      document.querySelectorAll('.chart-container').forEach(container => {
        container.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-5px)';
          this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.15)';
        });
        
        container.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
          this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        });
      });
      }

      initializeCharts();
    });
  </script>
</body>
</html>
