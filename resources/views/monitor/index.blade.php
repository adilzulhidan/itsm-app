<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NetShark Web | Server Traffic Analyzer</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Light Mode Colors */
            --bg-app: #ffffff;
            --bg-panel: #f5f5f5;
            --border: #d4d4d4;
            --highlight: #0078d7;
            --text-main: #333;
            
            /* Wireshark Classic Colors - Light */
            --color-udp: #daeeff;
            --color-tcp: #e7e6ff;
            --color-http: #e4ffc7;
            --color-error: #1c1c1c;
            --text-error: #ff5c5c;
            --color-icmp: #fce0ff;
            
            /* Dark Mode Colors */
            --bg-app-dark: #0d1117;
            --bg-panel-dark: #161b22;
            --border-dark: #30363d;
            --highlight-dark: #58a6ff;
            --text-main-dark: #c9d1d9;
            
            /* Wireshark Classic Colors - Dark */
            --color-udp-dark: #1a3c5a;
            --color-tcp-dark: #2a2a5e;
            --color-http-dark: #2d5a27;
            --color-error-dark: #3a3a3a;
            --text-error-dark: #ff6b6b;
            --color-icmp-dark: #5a2a5a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Inter', sans-serif; 
            background: var(--bg-app); 
            height: 100vh; 
            display: flex; 
            flex-direction: column; 
            overflow: hidden;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        body.dark {
            background: var(--bg-app-dark);
            color: var(--text-main-dark);
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 100;
            background: transparent;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 16px;
            padding: 5px;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #333;
        }

        body.dark .theme-toggle {
            color: #8b949e;
        }

        body.dark .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #c9d1d9;
        }

        /* TOOLBAR */
        .toolbar {
            background: #f0f0f0; 
            border-bottom: 1px solid var(--border);
            padding: 5px 10px; 
            display: flex; 
            gap: 10px; 
            align-items: center;
            height: 40px;
            transition: all 0.3s ease;
        }

        body.dark .toolbar {
            background: var(--bg-panel-dark);
            border-bottom: 1px solid var(--border-dark);
        }
        
        .btn-tool {
            border: 1px solid transparent; 
            background: none; 
            padding: 4px 8px; 
            cursor: pointer; 
            border-radius: 3px;
            color: #333;
            transition: all 0.2s ease;
        }

        body.dark .btn-tool {
            color: var(--text-main-dark);
        }
        
        .btn-tool:hover { 
            background: #dcdcdc; 
            border: 1px solid #ccc; 
        }

        body.dark .btn-tool:hover { 
            background: #30363d; 
            border: 1px solid #8b949e; 
        }
        
        .btn-tool.active { 
            background: #cce8ff; 
            border: 1px solid #99d1ff; 
        }

        body.dark .btn-tool.active { 
            background: rgba(88, 166, 255, 0.2); 
            border: 1px solid rgba(88, 166, 255, 0.4); 
            color: #58a6ff;
        }
        
        .filter-bar {
            flex: 1; 
            display: flex; 
            align-items: center; 
            background: #fff; 
            border: 1px solid #ccc; 
            padding: 0 5px; 
            height: 26px; 
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        body.dark .filter-bar {
            background: var(--bg-app-dark);
            border: 1px solid var(--border-dark);
        }

        .filter-input {
            border: none; 
            outline: none; 
            flex: 1; 
            font-family: 'Roboto Mono'; 
            font-size: 12px; 
            padding-left: 5px;
            background: #e4ffc7;
            color: #333;
            transition: all 0.3s ease;
        }

        body.dark .filter-input {
            background: #2d5a27;
            color: var(--text-main-dark);
        }

        /* MAIN SPLIT LAYOUT */
        .main-split {
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            overflow: hidden;
        }

        /* PACKET LIST (TOP) */
        .packet-list-container {
            flex: 2; 
            overflow: auto; 
            border-bottom: 5px solid #e0e0e0; 
            position: relative;
            transition: border-color 0.3s ease;
        }

        body.dark .packet-list-container {
            border-bottom: 5px solid #30363d;
        }

        table.packet-table {
            width: 100%; 
            border-collapse: collapse; 
            font-family: 'Roboto Mono', monospace; 
            font-size: 11px;
        }
        
        th {
            background: #e6e6e6; 
            text-align: left; 
            padding: 4px 8px; 
            border-right: 1px solid #ccc; 
            border-bottom: 1px solid #ccc;
            font-weight: 600; 
            position: sticky; 
            top: 0; 
            z-index: 10; 
            cursor: pointer;
            color: #333;
            transition: all 0.3s ease;
        }

        body.dark th {
            background: var(--bg-panel-dark);
            border-right: 1px solid var(--border-dark);
            border-bottom: 1px solid var(--border-dark);
            color: var(--text-main-dark);
        }
        
        th:hover { 
            background: #dcdcdc; 
        }

        body.dark th:hover { 
            background: #30363d; 
        }

        td {
            padding: 2px 8px; 
            border-right: 1px solid #e0e0e0; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            cursor: pointer;
            color: #333;
            transition: all 0.3s ease;
        }

        body.dark td {
            border-right: 1px solid var(--border-dark);
            color: var(--text-main-dark);
        }
        
        /* Row Colors - Light Mode */
        tr.p-udp { background: var(--color-udp); }
        tr.p-tcp { background: var(--color-tcp); }
        tr.p-http { background: var(--color-http); }
        tr.p-icmp { background: var(--color-icmp); }
        tr.p-err { 
            background: var(--color-error); 
            color: var(--text-error); 
        }
        
        /* Row Colors - Dark Mode */
        body.dark tr.p-udp { background: var(--color-udp-dark); }
        body.dark tr.p-tcp { background: var(--color-tcp-dark); }
        body.dark tr.p-http { background: var(--color-http-dark); }
        body.dark tr.p-icmp { background: var(--color-icmp-dark); }
        body.dark tr.p-err { 
            background: var(--color-error-dark); 
            color: var(--text-error-dark); 
        }
        
        tr.selected {
            background: var(--highlight) !important; 
            color: white !important;
        }

        body.dark tr.selected {
            background: var(--highlight-dark) !important; 
            color: white !important;
        }

        /* PACKET DETAILS (BOTTOM) */
        .packet-details-container {
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            background: white; 
            font-family: 'Roboto Mono', monospace;
            transition: all 0.3s ease;
        }

        body.dark .packet-details-container {
            background: var(--bg-app-dark);
        }
        
        .tabs {
            background: #f0f0f0; 
            border-bottom: 1px solid #ccc; 
            display: flex;
            transition: all 0.3s ease;
        }

        body.dark .tabs {
            background: var(--bg-panel-dark);
            border-bottom: 1px solid var(--border-dark);
        }

        .tab {
            padding: 5px 15px; 
            cursor: pointer; 
            border-right: 1px solid #ccc; 
            font-weight: 500;
            color: #333;
            transition: all 0.3s ease;
        }

        body.dark .tab {
            border-right: 1px solid var(--border-dark);
            color: var(--text-main-dark);
        }

        .tab.active { 
            background: white; 
            border-bottom: 2px solid white; 
            margin-bottom: -1px; 
        }

        body.dark .tab.active { 
            background: var(--bg-app-dark); 
            border-bottom: 2px solid var(--bg-app-dark); 
        }

        .detail-content {
            flex: 1; 
            overflow: auto; 
            padding: 10px; 
            display: flex; 
            gap: 20px;
        }
        
        .tree-view { 
            flex: 1; 
            border-right: 1px solid #eee; 
            color: #333;
            transition: all 0.3s ease;
        }

        body.dark .tree-view {
            border-right: 1px solid var(--border-dark);
            color: var(--text-main-dark);
        }

        .hex-view { 
            flex: 1; 
            color: #555; 
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        body.dark .hex-view {
            color: #8b949e;
        }

        .tree-item { 
            margin-bottom: 2px; 
            color: #333;
        }

        body.dark .tree-item {
            color: var(--text-main-dark);
        }

        .tree-item i { 
            width: 15px; 
            color: #666; 
            font-size: 10px;
        }

        body.dark .tree-item i {
            color: #8b949e;
        }

        /* Back Button */
        .back-btn {
            text-decoration: none; 
            color: #333; 
            margin-right: 15px; 
            border-right: 1px solid #ccc; 
            padding-right: 10px; 
            display: flex; 
            align-items: center; 
            gap: 5px;
            transition: all 0.3s ease;
        }

        body.dark .back-btn {
            color: var(--text-main-dark);
            border-right: 1px solid var(--border-dark);
        }

        .back-btn i {
            color: #666;
            transition: color 0.3s ease;
        }

        body.dark .back-btn i {
            color: #8b949e;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar { 
            width: 8px; 
            height: 8px; 
        }
        
        ::-webkit-scrollbar-track { 
            background: #f1f1f1; 
        }
        
        ::-webkit-scrollbar-thumb { 
            background: #c1c1c1; 
        }
        
        ::-webkit-scrollbar-thumb:hover { 
            background: #a8a8a8; 
        }

        body.dark ::-webkit-scrollbar-track { 
            background: #161b22; 
        }
        
        body.dark ::-webkit-scrollbar-thumb { 
            background: #30363d; 
        }
        
        body.dark ::-webkit-scrollbar-thumb:hover { 
            background: #484f58; 
        }
    </style>
</head>
<body class="dark">

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="theme-toggle" title="Toggle Dark Mode">
        <i class="fas fa-moon"></i>
    </button>

    <div class="toolbar">
        <a href="{{ route('dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> 
            <span style="font-weight: 600;">Back</span>
        </a>

        <button class="btn-tool active" id="btn-start" title="Start Capture">
            <i class="fas fa-shark" style="color:#0078d7"></i>
        </button>
        <button class="btn-tool" id="btn-stop" title="Stop Capture">
            <i class="fas fa-square" style="color:#cf2a2a"></i>
        </button>
        <button class="btn-tool" title="Restart">
            <i class="fas fa-redo"></i>
        </button>
        
        <div style="width: 1px; height: 20px; background: #ccc; margin: 0 5px;"></div>
        
        <div class="filter-bar">
            <span style="font-weight: 600; margin-right: 5px; color: #666;">Apply a display filter:</span>
            <input type="text" class="filter-input" value="ip.addr == {{ $_SERVER['REMOTE_ADDR'] ?? '192.168.1.10' }}" id="filter-input">
            <i class="fas fa-arrow-right" style="color: #666; cursor: pointer; padding: 0 5px;"></i>
        </div>
    </div>

    <div class="main-split">
        
        <div class="packet-list-container" id="plist-container">
            <table class="packet-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th style="width: 100px;">Time</th>
                        <th style="width: 150px;">Source</th>
                        <th style="width: 150px;">Destination</th>
                        <th style="width: 80px;">Protocol</th>
                        <th style="width: 80px;">Length</th>
                        <th>Info</th>
                    </tr>
                </thead>
                <tbody id="packet-tbody">
                    </tbody>
            </table>
        </div>

        <div class="packet-details-container">
            <div class="tabs">
                <div class="tab active">Packet Details</div>
                <div class="tab">Packet Bytes</div>
            </div>
            <div class="detail-content">
                <div class="tree-view" id="detail-tree">
                    <div style="color: #999; padding: 20px; text-align: center;">Select a packet to view details</div>
                </div>

                <div class="hex-view" id="detail-hex">
                    </div>
            </div>
        </div>
    </div>

    <script>
        const App = {
            isRunning: true,
            packetCount: 0,
            packets: [],
            maxPackets: 500, // Limit DOM elements for performance
            
            // Configuration for Network Simulation
            officeSubnet: '192.168.10.',
            serverIP: '192.168.10.5 (SRV-MAIN)',
            protocols: ['TCP', 'UDP', 'HTTP', 'TLSv1.2', 'ICMP', 'DNS'],

            init() {
                // Theme Toggle
                const themeToggle = document.getElementById('theme-toggle');
                themeToggle.onclick = () => {
                    document.body.classList.toggle('dark');
                    const icon = themeToggle.querySelector('i');
                    if (document.body.classList.contains('dark')) {
                        icon.className = 'fas fa-moon';
                        icon.style.color = '#f0db4f';
                    } else {
                        icon.className = 'fas fa-sun';
                        icon.style.color = '#ff9800';
                    }
                };

                // Set initial theme icon
                const themeIcon = themeToggle.querySelector('i');
                themeIcon.style.color = document.body.classList.contains('dark') ? '#f0db4f' : '#ff9800';
                themeIcon.className = document.body.classList.contains('dark') ? 'fas fa-moon' : 'fas fa-sun';

                // Event Listeners
                document.getElementById('btn-stop').onclick = () => this.toggleCapture(false);
                document.getElementById('btn-start').onclick = () => this.toggleCapture(true);
                
                // Start Simulation Loop
                this.loop();
            },

            toggleCapture(state) {
                this.isRunning = state;
                document.getElementById('btn-start').classList.toggle('active', state);
                document.getElementById('btn-stop').classList.toggle('active', !state);
            },

            // --- SIMULATOR LOGIC ---
            generatePacket() {
                this.packetCount++;
                const now = new Date();
                const timeStr = `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}:${now.getSeconds().toString().padStart(2, '0')}.${Math.floor(now.getMilliseconds() / 100)}`;
                
                // Randomize Packet Type
                const proto = this.protocols[Math.floor(Math.random() * this.protocols.length)];
                let src, dst, info, length, cssClass;

                // Logic to mimic office traffic
                if (proto === 'HTTP') {
                    src = this.officeSubnet + Math.floor(Math.random() * 254);
                    dst = this.serverIP;
                    length = Math.floor(Math.random() * 1500) + 400;
                    info = `GET /api/v1/data HTTP/1.1`;
                    cssClass = 'p-http';
                } else if (proto === 'TCP') {
                    src = this.serverIP;
                    dst = this.officeSubnet + Math.floor(Math.random() * 254);
                    length = 64;
                    const flags = ['[SYN]', '[ACK]', '[PSH, ACK]', '[FIN, ACK]'];
                    info = `443 → 582${Math.floor(Math.random()*9)} ${flags[Math.floor(Math.random()*flags.length)]} Seq=${this.packetCount} Ack=1 Win=65535 Len=0`;
                    cssClass = 'p-tcp';
                } else if (proto === 'DNS') {
                    src = this.officeSubnet + '20';
                    dst = '8.8.8.8';
                    length = 89;
                    info = `Standard query 0x${Math.floor(Math.random()*9999).toString(16).toUpperCase()} A google.com`;
                    cssClass = 'p-udp';
                } else if (proto === 'ICMP') {
                    src = this.officeSubnet + '100';
                    dst = this.serverIP;
                    length = 74;
                    info = 'Echo (ping) request  id=0x0001, seq=12/3072, ttl=64';
                    cssClass = 'p-icmp';
                } else {
                    // Random / Error
                    src = '10.0.0.' + Math.floor(Math.random() * 50);
                    dst = '255.255.255.255';
                    length = 1514;
                    info = 'TCP Retransmission';
                    cssClass = Math.random() > 0.9 ? 'p-err' : 'p-udp';
                }

                const packet = {
                    no: this.packetCount,
                    time: timeStr,
                    src, dst, proto, length, info, cssClass
                };

                this.addPacketToTable(packet);
            },

            addPacketToTable(pkt) {
                const tbody = document.getElementById('packet-tbody');
                const row = document.createElement('tr');
                row.className = pkt.cssClass;
                row.innerHTML = `
                    <td>${pkt.no}</td>
                    <td>${pkt.time}</td>
                    <td>${pkt.src}</td>
                    <td>${pkt.dst}</td>
                    <td>${pkt.proto}</td>
                    <td>${pkt.length}</td>
                    <td>${pkt.info}</td>
                `;
                
                // Click Event
                row.onclick = () => {
                    // Remove other selections
                    document.querySelectorAll('tr.selected').forEach(el => el.classList.remove('selected'));
                    row.classList.add('selected');
                    this.renderDetails(pkt);
                };

                tbody.appendChild(row);

                // Auto scroll to bottom if near bottom
                const container = document.getElementById('plist-container');
                if(container.scrollHeight - container.scrollTop <= container.clientHeight + 100) {
                    container.scrollTop = container.scrollHeight;
                }

                // Cleanup old packets
                if(tbody.children.length > this.maxPackets) {
                    tbody.removeChild(tbody.firstChild);
                }
            },

            renderDetails(pkt) {
                // Mimic Wireshark Layer Tree
                const tree = document.getElementById('detail-tree');
                tree.innerHTML = `
                    <div class="tree-item"><i class="fas fa-caret-right"></i> Frame ${pkt.no}: ${pkt.length} bytes on wire ({{ $frameBits ?? '1200' }} bits)</div>
                    <div class="tree-item"><i class="fas fa-caret-right"></i> Ethernet II, Src: Dell_7a:2b:1c (00:14:22:01:23:45), Dst: Cisco_c0:01:02 (00:00:0c:9f:f0:01)</div>
                    <div class="tree-item"><i class="fas fa-caret-right"></i> Internet Protocol Version 4, Src: ${pkt.src}, Dst: ${pkt.dst}</div>
                    <div class="tree-item"><i class="fas fa-caret-down"></i> ${pkt.proto === 'HTTP' ? 'Transmission Control Protocol (TCP)' : pkt.proto + ' Protocol'}</div>
                    <div style="padding-left: 20px; font-size: 11px; color: #444;">
                        <div>Source Port: ${Math.floor(Math.random()*65000)}</div>
                        <div>Destination Port: ${pkt.proto === 'HTTP' ? 80 : 443}</div>
                        <div>[Stream index: 12]</div>
                    </div>
                    ${pkt.proto === 'HTTP' ? '<div class="tree-item"><i class="fas fa-caret-right"></i> Hypertext Transfer Protocol</div>' : ''}
                `;

                // Update colors for dark mode
                if (document.body.classList.contains('dark')) {
                    tree.querySelectorAll('div').forEach(div => {
                        if (div.style.color === 'rgb(68, 68, 68)') {
                            div.style.color = '#8b949e';
                        }
                    });
                }

                // Mimic Hex Dump
                const hexDiv = document.getElementById('detail-hex');
                let hexContent = '';
                // Generate dummy hex
                for(let i=0; i<8; i++) {
                    const offset = (i*16).toString(16).padStart(4, '0');
                    const bytes = Array.from({length: 16}, () => Math.floor(Math.random()*255).toString(16).padStart(2,'0')).join(' ');
                    const ascii = '................'; // Dummy ascii
                    const offsetColor = document.body.classList.contains('dark') ? '#58a6ff' : '#0078d7';
                    const bytesColor = document.body.classList.contains('dark') ? '#c9d1d9' : '#333';
                    const asciiColor = document.body.classList.contains('dark') ? '#8b949e' : '#888';
                    hexContent += `<div><span style="color:${offsetColor}">${offset}</span>   <span style="color:${bytesColor}">${bytes}</span>   <span style="color:${asciiColor}">${ascii}</span></div>`;
                }
                hexDiv.innerHTML = `<div style="font-weight:bold; margin-bottom:5px; color:${document.body.classList.contains('dark') ? '#c9d1d9' : '#333'}">Data (${pkt.length} bytes)</div>` + hexContent;
            },

            loop() {
                // Random interval between packets (50ms - 800ms)
                const delay = Math.random() * 800 + 50;
                setTimeout(() => {
                    if (this.isRunning) this.generatePacket();
                    this.loop();
                }, delay);
            }
        };

        document.addEventListener('DOMContentLoaded', () => App.init());
    </script>
</body>
</html>