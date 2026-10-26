<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emiliano Carreño | Full Stack Developer & Salesforce Specialist</title>
    <!-- Salesforce-inspired Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sf-blue-deep: #032d60;       
            --sf-blue-primary: #0176d3;    
            --sf-blue-hover: #014b87;      
            --sf-cloud-bg: #f3f3f3;        
            --sf-text-dark: #181818;       
            --sf-text-muted: #444444;      
            --sf-border: #dddbda;          
            --sf-white: #ffffff;
            --sf-gradient: linear-gradient(135deg, #0176d3 0%, #032d60 100%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--sf-white);
            color: var(--sf-text-dark);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        header {
            background-color: var(--sf-white);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--sf-border);
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
        }

        .logo {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--sf-blue-deep);
            text-decoration: none;
            letter-spacing: -0.03rem;
        }

        .logo span {
            color: var(--sf-blue-primary);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            color: var(--sf-text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: color 0.1s ease;
        }

        .nav-links a:hover {
            color: var(--sf-blue-primary);
        }

        .hero-wrapper {
            background: var(--sf-gradient);
            color: var(--sf-white);
            padding: 10rem 2rem 8rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-wrapper::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4rem;
            background: var(--sf-white);
            border-radius: 100% 100% 0 0 / 100% 100% 0 0;
            transform: scaleX(1.2);
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: -0.06rem;
            line-height: 1.1;
        }

        .hero h1 span {
            color: #38bdf8;
        }

        .hero p {
            font-size: 1.35rem;
            max-width: 800px;
            margin: 0 auto 2.5rem;
            font-weight: 400;
            opacity: 0.95;
        }

        .social-badges {
            display: flex;
            justify-content: center;
            gap: 1rem;
            position: relative;
            z-index: 10;
        }

        .btn-sf {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.85rem 2rem;
            border-radius: 4px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
            cursor: pointer;
        }

        .btn-sf.primary {
            background-color: #229342; 
            color: var(--sf-white);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-sf.primary:hover {
            background-color: #1a7531;
            transform: translateY(-1px);
        }

        .btn-sf.secondary {
            background-color: transparent;
            color: var(--sf-white);
            border: 2px solid var(--sf-white);
        }

        .btn-sf.secondary:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 2rem 6rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.25rem;
            color: var(--sf-blue-deep);
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.04rem;
        }

        .section-header p {
            color: var(--sf-text-muted);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 4rem;
            margin-bottom: 6rem;
            align-items: start;
        }

        @media (max-width: 768px) {
            .about-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .hero h1 {
                font-size: 2.5rem;
            }
        }

        .about-text p {
            color: var(--sf-text-dark);
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .skills-card {
            background-color: var(--sf-cloud-bg);
            border: 1px solid var(--sf-border);
            border-radius: 8px;
            padding: 2.5rem;
        }

        .skills-card h3 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            color: var(--sf-blue-deep);
            font-weight: 700;
        }

        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            list-style: none;
        }

        .skill-item {
            background-color: var(--sf-white);
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: 1px solid var(--sf-border);
            color: var(--sf-blue-deep);
        }

        .portfolio-tabs {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 3rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }

        .tab-btn {
            background: var(--sf-white);
            border: 1px solid var(--sf-border);
            color: var(--sf-blue-primary);
            padding: 0.6rem 1.4rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.95rem;
            white-space: nowrap;
            transition: all 0.1s ease;
        }

        .tab-btn.active, .tab-btn:hover {
            background-color: var(--sf-blue-primary);
            color: var(--sf-white);
            border-color: var(--sf-blue-primary);
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 2rem;
        }

        .project-card {
            background-color: var(--sf-white);
            border: 1px solid var(--sf-border);
            border-radius: 8px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .project-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(1, 118, 211, 0.08);
            border-color: var(--sf-blue-primary);
        }

        .project-header {
            margin-bottom: 1.5rem;
        }

        .project-tag {
            display: inline-block;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.06rem;
            color: var(--sf-blue-primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .project-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--sf-blue-deep);
            margin-bottom: 0.5rem;
        }

        .project-url {
            font-size: 0.9rem;
            color: var(--sf-text-muted);
            word-break: break-all;
            text-decoration: none;
            display: block;
        }

        .btn-visit {
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--sf-blue-primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 700;
            margin-top: 1.5rem;
        }

        .btn-visit:hover {
            color: var(--sf-blue-hover);
            text-decoration: underline;
        }

        footer {
            background-color: var(--sf-blue-deep);
            color: var(--sf-white);
            padding: 3rem 2rem;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        footer p {
            font-size: 1rem;
            opacity: 0.8;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <header>
        <div class="nav-container">
            <a href="#" class="logo">emilianocarreno<span>.io</span></a>
            <ul class="nav-links">
                <li><a href="#sobre-mi">Sobre Mí</a></li>
                <li><a href="#proyectos">Proyectos</a></li>
                <li><a href="mailto:contact@emilianocarreno.io">Contacto</a></li>
            </ul>
        </div>
    </header>

    <div class="hero-wrapper">
        <section class="hero">
            <h1>Hola, soy <span>Emiliano Carreño</span></h1>
            <p>Full Stack Developer & Especialista en Soluciones Salesforce CRM. Más de 10 años optimizando ecosistemas tecnológicos, flujos complejos y despliegues robustos en la nube.</p>
            <div class="social-badges">
                <a href="mailto:contact@emilianocarreno.io" class="btn-sf primary"><i class="fa-regular fa-envelope"></i> contact@emilianocarreno.io</a>
                <a href="https://linkedin.com/in/emilianocarrenodev/" target="_blank" class="btn-sf secondary"><i class="fa-brands fa-linkedin"></i> LinkedIn</a>
            </div>
        </section>
    </div>

    <main>
        <section id="sobre-mi">
            <div class="section-header">
                <h2>Trayectoria Profesional</h2>
                <p>Especialista técnico enfocado en la arquitectura y rendimiento empresarial</p>
            </div>
            <div class="about-grid">
                <div class="about-text">
                    <p>Cuento con más de <strong>10 años de experiencia</strong> desarrollando aplicaciones web de alto rendimiento con <strong>Laravel</strong>, especializándome en arquitecturas complejas, operaciones CRUD avanzadas, generación automatizada de documentos estructurados (PDF/Excel) y despliegue de diseños completamente a medida.</p>
                    <p>Además, dispongo de una trayectoria de más de 8 años transformando diseños conceptuales en código estructurado utilizando HTML5, Bootstrap, Sass y Webpack, facilitando su posterior integración nativa en ecosistemas SaaS corporativos como <strong>Salesforce y Zoho</strong>.</p>
                </div>
                <div>
                    <div class="skills-card">
                        <h3>Stack Tecnológico</h3>
                        <ul class="skills-list">
                            <li class="skill-item">Salesforce CRM</li>
                            <li class="skill-item">Laravel Ecosystem</li>
                            <li class="skill-item">Cloud Solutions</li>
                            <li class="skill-item">Zoho Suite</li>
                            <li class="skill-item">HTML5 / Sass</li>
                            <li class="skill-item">Webpack / Bootstrap</li>
                            <li class="skill-item">WordPress / Woo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="proyectos">
            <div class="section-header">
                <h2>Portafolio de Aplicaciones y Soluciones</h2>
                <p>Explora los ecosistemas web, integraciones y proyectos de ingeniería digital realizados</p>
            </div>
            
            <div class="portfolio-tabs">
                <button class="tab-btn active" onclick="filterProjects('all', event)">Todos</button>
                <button class="tab-btn" onclick="filterProjects('laravel', event)">Laravel Applications</button>
                <button class="tab-btn" onclick="filterProjects('wordpress', event)">WordPress & WooCommerce</button>
                <button class="tab-btn" onclick="filterProjects('frontend', event)">Frontend Development</button>
                <button class="tab-btn" onclick="filterProjects('kit-digital', event)">Digital Kit</button>
            </div>

            <div class="project-grid">
                <div class="project-card" data-category="laravel">
                    <div class="project-header">
                        <span class="project-tag">Laravel Application</span>
                        <h3>Lesiga</h3>
                        <a href="https://lesiga.com/" target="_blank" class="project-url">lesiga.com</a>
                    </div>
                    <a href="https://lesiga.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="laravel">
                    <div class="project-header">
                        <span class="project-tag">Laravel Application</span>
                        <h3>Fiducentral</h3>
                        <a href="https://www.fiducentral.com/" target="_blank" class="project-url">fiducentral.com</a>
                    </div>
                    <a href="https://www.fiducentral.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="wordpress">
                    <div class="project-header">
                        <span class="project-tag">WordPress & Elementor</span>
                        <h3>YourCreams</h3>
                        <a href="https://yourcreams.wpdinamiq.com/" target="_blank" class="project-url">yourcreams.wpdinamiq.com</a>
                    </div>
                    <a href="https://yourcreams.wpdinamiq.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="wordpress">
                    <div class="project-header">
                        <span class="project-tag">WordPress & Elementor</span>
                        <h3>Segreco</h3>
                        <a href="https://segreco.com/" target="_blank" class="project-url">segreco.com</a>
                    </div>
                    <a href="https://segreco.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="wordpress">
                    <div class="project-header">
                        <span class="project-tag">WordPress Custom</span>
                        <h3>Bufito</h3>
                        <a href="http://bufito.com/" target="_blank" class="project-url">bufito.com</a>
                    </div>
                    <a href="http://bufito.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="wordpress">
                    <div class="project-header">
                        <span class="project-tag">WordPress Custom</span>
                        <h3>Clínica Mireia Espinosa</h3>
                        <a href="http://clinicamireiaespinosa.com/" target="_blank" class="project-url">clinicamireiaespinosa.com</a>
                    </div>
                    <a href="http://clinicamireiaespinosa.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="frontend">
                    <div class="project-header">
                        <span class="project-tag">Frontend (Sass & Webpack)</span>
                        <h3>Immomas</h3>
                        <a href="https://immomas.net/" target="_blank" class="project-url">immomas.net</a>
                    </div>
                    <a href="https://immomas.net/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="frontend">
                    <div class="project-header">
                        <span class="project-tag">Frontend (Sass & Webpack)</span>
                        <h3>Seaszen</h3>
                        <a href="https://seaszen.com/" target="_blank" class="project-url">seaszen.com</a>
                    </div>
                    <a href="https://seaszen.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="frontend">
                    <div class="project-header">
                        <span class="project-tag">Frontend (Sass & Webpack)</span>
                        <h3>Suzuki Moto España</h3>
                        <a href="https://moto.suzuki.es/" target="_blank" class="project-url">moto.suzuki.es</a>
                    </div>
                    <a href="https://moto.suzuki.es/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="kit-digital">
                    <div class="project-header">
                        <span class="project-tag">Digital Kit Project</span>
                        <h3>Dadral Games</h3>
                        <a href="https://dadralgames.com/" target="_blank" class="project-url">dadralgames.com</a>
                    </div>
                    <a href="https://dadralgames.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="kit-digital">
                    <div class="project-header">
                        <span class="project-tag">Digital Kit Project</span>
                        <h3>Cynthia Román Interiorismo</h3>
                        <a href="https://cynthiaroman-interiorismo.com/" target="_blank" class="project-url">cynthiaroman-interiorismo.com</a>
                    </div>
                    <a href="https://cynthiaroman-interiorismo.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>

                <div class="project-card" data-category="kit-digital">
                    <div class="project-header">
                        <span class="project-tag">Digital Kit Project</span>
                        <h3>Taesa GI</h3>
                        <a href="https://www.taesa-gi.com/" target="_blank" class="project-url">taesa-gi.com</a>
                    </div>
                    <a href="https://www.taesa-gi.com/" target="_blank" class="btn-visit">Ver Proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Emiliano Carreño.</p>
    </footer>

    <script>
        function filterProjects(category, event) {
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            const cards = document.querySelectorAll('.project-card');
            cards.forEach(card => {
                if (category === 'all' || card.getAttribute('data-category') === category) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>