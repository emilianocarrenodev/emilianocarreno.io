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
    @vite('resources/css/welcome.css')
</head>
<body>

    {{-- @include('partials.header') --}}

    <div class="hero-wrapper">
        <section class="hero">
            <h1>Hola, soy <span>Emiliano Carreño</span></h1>
            <p>Full Stack Developer & Especialista en Soluciones Salesforce CRM. Más de 10 años optimizando ecosistemas tecnológicos, flujos complejos y despliegues robustos en la nube.</p>
            <div class="social-badges">
                <a href="mailto:contact@emilianocarreno.io" class="btn-sf primary"><i class="fa-regular fa-envelope"></i> contact@emilianocarreno.io</a>
                <a href="https://linkedin.com/in/emilianocarrenodev/" target="_blank" rel="noopener noreferrer" class="btn-sf secondary"><i class="fa-brands fa-linkedin"></i> LinkedIn</a>
                <a href="https://github.com/emilianocarrenodev" target="_blank" rel="noopener noreferrer" class="btn-sf secondary"><i class="fa-brands fa-github"></i> GitHub</a>
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

    @include('partials.footer')

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