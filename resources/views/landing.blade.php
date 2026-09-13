<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Kart — Gestão de campeonatos de kart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <style>
        :root {
            --brand: #f59e0b;
            --brand-dark: #d97706;
        }

        body { margin: 0; }

        /* NAV */
        nav.top-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #111827;
            border-bottom: 1px solid #1f2937;
            padding: 0.75rem 0;
        }
        nav.top-nav .inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--brand);
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .logo span { color: #f3f4f6; }
        .nav-actions { display: flex; gap: 0.75rem; align-items: center; }
        .btn-outline {
            padding: 0.4rem 1rem;
            border: 1px solid #374151;
            border-radius: 6px;
            color: #d1d5db;
            text-decoration: none;
            font-size: 0.875rem;
            transition: border-color 0.2s, color 0.2s;
        }
        .btn-outline:hover { border-color: var(--brand); color: var(--brand); }
        .btn-primary {
            padding: 0.4rem 1rem;
            background: var(--brand);
            border-radius: 6px;
            color: #111827;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: var(--brand-dark); color: #111827; }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            padding: 5rem 1.5rem 4rem;
            text-align: center;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(245,158,11,0.15);
            border: 1px solid rgba(245,158,11,0.3);
            color: var(--brand);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.3rem 0.9rem;
            border-radius: 999px;
            margin-bottom: 1.5rem;
            letter-spacing: 0.05em;
        }
        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.25rem);
            font-weight: 800;
            color: #f9fafb;
            line-height: 1.15;
            margin: 0 auto 1.25rem;
            max-width: 750px;
        }
        .hero h1 em { color: var(--brand); font-style: normal; }
        .hero p {
            font-size: 1.125rem;
            color: #9ca3af;
            max-width: 580px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }
        .hero-cta { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-hero {
            padding: 0.75rem 2rem;
            background: var(--brand);
            border-radius: 8px;
            color: #111827;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 700;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-hero:hover { background: var(--brand-dark); transform: translateY(-1px); color: #111827; }
        .btn-hero-ghost {
            padding: 0.75rem 2rem;
            border: 1px solid #374151;
            border-radius: 8px;
            color: #d1d5db;
            text-decoration: none;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        .btn-hero-ghost:hover { border-color: #6b7280; color: #f3f4f6; }
        .trial-note {
            margin-top: 1rem;
            font-size: 0.8rem;
            color: #6b7280;
        }

        /* FEATURES */
        .section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 4rem 1.5rem;
        }
        .section-label {
            text-align: center;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: var(--brand);
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }
        .section h2 {
            text-align: center;
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 700;
            color: #f9fafb;
            margin-bottom: 0.5rem;
        }
        .section-sub {
            text-align: center;
            color: #9ca3af;
            max-width: 520px;
            margin: 0 auto 3rem;
            font-size: 1rem;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
            gap: 1.5rem;
        }
        .feature-card {
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 12px;
            padding: 1.75rem;
            transition: border-color 0.2s;
        }
        .feature-card:hover { border-color: var(--brand); }
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .feature-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #f3f4f6;
            margin-bottom: 0.5rem;
        }
        .feature-card p {
            color: #9ca3af;
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0;
        }

        /* PRICING */
        .pricing-bg {
            background: #111827;
            border-top: 1px solid #1f2937;
            border-bottom: 1px solid #1f2937;
        }
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            max-width: 700px;
            margin: 0 auto;
        }
        .plan-card {
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 16px;
            padding: 2rem;
            position: relative;
        }
        .plan-card.featured {
            border-color: var(--brand);
            background: #1c1917;
        }
        .plan-badge {
            position: absolute;
            top: -0.75rem;
            left: 50%;
            transform: translateX(-50%);
            background: var(--brand);
            color: #111827;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.75rem;
            border-radius: 999px;
            white-space: nowrap;
            letter-spacing: 0.05em;
        }
        .plan-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #f3f4f6;
            margin-bottom: 0.25rem;
        }
        .plan-price {
            font-size: 2.5rem;
            font-weight: 800;
            color: #f9fafb;
            line-height: 1;
            margin: 1rem 0 0.25rem;
        }
        .plan-price sup { font-size: 1rem; vertical-align: top; margin-top: 0.5rem; display: inline-block; }
        .plan-period { font-size: 0.8rem; color: #6b7280; margin-bottom: 1.5rem; }
        .plan-features { list-style: none; padding: 0; margin: 0 0 2rem; }
        .plan-features li {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.9rem;
            color: #d1d5db;
            padding: 0.35rem 0;
            border-bottom: 1px solid #374151;
        }
        .plan-features li:last-child { border-bottom: none; }
        .check { color: #10b981; font-weight: 700; }
        .cross { color: #6b7280; }
        .plan-cta {
            display: block;
            text-align: center;
            padding: 0.65rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: background 0.2s;
        }
        .plan-card:not(.featured) .plan-cta {
            background: #374151;
            color: #f3f4f6;
        }
        .plan-card:not(.featured) .plan-cta:hover { background: #4b5563; color: #f3f4f6; }
        .plan-card.featured .plan-cta {
            background: var(--brand);
            color: #111827;
        }
        .plan-card.featured .plan-cta:hover { background: var(--brand-dark); color: #111827; }

        /* PUBLIC TEAMS */
        .teams-section { text-align: center; }
        .teams-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
            margin-top: 1.5rem;
        }
        .team-chip {
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 999px;
            padding: 0.4rem 1.1rem;
            font-size: 0.875rem;
            color: #d1d5db;
            text-decoration: none;
            transition: border-color 0.2s, color 0.2s;
        }
        .team-chip:hover { border-color: var(--brand); color: var(--brand); }

        /* CTA BANNER */
        .cta-banner {
            background: linear-gradient(135deg, #1e1b4b, #0f172a);
            text-align: center;
            padding: 4rem 1.5rem;
            border-top: 1px solid #1f2937;
        }
        .cta-banner h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            color: #f9fafb;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }
        .cta-banner p { color: #9ca3af; margin-bottom: 2rem; }

        /* FOOTER */
        footer {
            background: #0f172a;
            border-top: 1px solid #1f2937;
            padding: 2rem 1.5rem;
            text-align: center;
            color: #4b5563;
            font-size: 0.8rem;
        }
        footer a { color: #6b7280; text-decoration: none; }
        footer a:hover { color: var(--brand); }
        .divider { border-top: 1px solid #1f2937; }
    </style>
</head>
<body>

{{-- NAV --}}
<nav class="top-nav">
    <div class="inner">
        <a href="/" class="logo">System<span>Kart</span></a>
        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn-outline">Entrar</a>
            <a href="{{ route('register') }}" class="btn-primary">Criar conta</a>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-badge">14 dias grátis · sem cartão</div>
    <h1>Gestão de campeonato de kart para o seu <em>kartódromo</em></h1>
    <p>Importe corridas, calcule ranking automaticamente, compartilhe resultados públicos com seus pilotos — tudo em um só lugar.</p>
    <div class="hero-cta">
        <a href="{{ route('register') }}" class="btn-hero">Criar conta grátis</a>
    </div>
    <p class="trial-note">Teste por 14 dias sem precisar de cartão de crédito.</p>
</section>

{{-- FEATURES --}}
<section class="section">
    <p class="section-label">Funcionalidades</p>
    <h2>Tudo que você precisa para gerir seu campeonato</h2>
    <p class="section-sub">Sem planilhas, sem dor de cabeça. Focado em kart.</p>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🏁</div>
            <h3>Importação de corridas</h3>
            <p>Importe os resultados de cada bater​ia via CSV em segundos. O sistema identifica automaticamente seus pilotos.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🏆</div>
            <h3>Ranking automático</h3>
            <p>Pontuação calculada automaticamente após cada corrida: 10 pts para o 1°, até 1 pt para o 10°. Atualize com um clique.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3>Painel público</h3>
            <p>Cada equipe tem uma página pública com o ranking do campeonato. Compartilhe o link com seus pilotos.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <h3>Gestão de membros</h3>
            <p>Adicione pilotos, defina administradores e controle o acesso à sua equipe com facilidade.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⏱️</div>
            <h3>Melhor volta</h3>
            <p>Acompanhe o TMV (tempo de melhor volta) de cada piloto ao longo de todo o campeonato.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔌</div>
            <h3>API integrada <small style="color:var(--brand);font-size:0.7rem">PRO</small></h3>
            <p>Integre seu sistema de cronometragem diretamente via API REST. Disponível no plano Pro.</p>
        </div>
    </div>
</section>

{{-- PRICING --}}
<div class="pricing-bg">
    <section class="section" id="precos">
        <p class="section-label">Planos</p>
        <h2>Simples e transparente</h2>
        <p class="section-sub">Escolha o plano ideal para o seu kartódromo. Cancele quando quiser.</p>

        <div class="pricing-grid">
            {{-- Básico --}}
            <div class="plan-card">
                <div class="plan-name">Básico</div>
                <div class="plan-price"><sup>R$</sup>10</div>
                <div class="plan-period">por mês</div>
                <ul class="plan-features">
                    <li><span class="check">✓</span> Até 10 pilotos</li>
                    <li><span class="check">✓</span> Até 2 corridas/mês</li>
                    <li><span class="check">✓</span> Ranking automático</li>
                    <li><span class="check">✓</span> Painel público</li>
                    <li><span class="check">✓</span> Importação CSV</li>
                    <li><span class="cross">✗</span> Acesso à API</li>
                </ul>
                <a href="{{ route('register') }}" class="plan-cta">Começar grátis</a>
            </div>

            {{-- Pro --}}
            <div class="plan-card featured">
                <div class="plan-badge">MAIS POPULAR</div>
                <div class="plan-name">Pro</div>
                <div class="plan-price"><sup>R$</sup>15</div>
                <div class="plan-period">por mês</div>
                <ul class="plan-features">
                    <li><span class="check">✓</span> Até 30 pilotos</li>
                    <li><span class="check">✓</span> Até 10 corridas/mês</li>
                    <li><span class="check">✓</span> Ranking automático</li>
                    <li><span class="check">✓</span> Painel público</li>
                    <li><span class="check">✓</span> Importação CSV</li>
                    <li><span class="check">✓</span> <strong style="color:#f3f4f6">Acesso à API REST</strong></li>
                </ul>
                <a href="{{ route('register') }}" class="plan-cta">Começar grátis</a>
            </div>
        </div>

        <p style="text-align:center;color:#6b7280;font-size:0.8rem;margin-top:1.5rem">
            Ambos os planos incluem 14 dias de trial gratuito sem necessidade de cartão.
        </p>
    </section>
</div>


{{-- CTA BANNER --}}
<div class="cta-banner">
    <h2>Pronto para modernizar seu campeonato?</h2>
    <p>Crie sua conta agora e gerencie tudo em menos de 5 minutos.</p>
    <a href="{{ route('register') }}" class="btn-hero">Criar conta grátis →</a>
</div>

{{-- FOOTER --}}
<footer>
    <p>© {{ date('Y') }} System Kart. Todos os direitos reservados.</p>
    <p style="margin-top:0.5rem">
        <a href="{{ route('login') }}">Entrar</a> ·
        <a href="{{ route('register') }}">Criar conta</a>
    </p>
</footer>

</body>
</html>
