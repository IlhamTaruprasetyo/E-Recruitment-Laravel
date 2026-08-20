<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" id="html-root">
<script>
    // Early theme detection — runs before CSS renders to prevent flash
    (function() {
        if (localStorage.getItem('mika-theme') === 'light') {
            document.getElementById('html-root').classList.add('light-mode');
        }
    })();
</script>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal E-Rekrutmen | Temukan Karir Impian Masa Depanmu')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind CSS CDN Fallback for instant styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary-green: #93F514;
            --primary-green-glow: rgba(147, 245, 20, 0.4);
            --primary-green-dark: #6bbd08;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        /* Custom Neon Green #93F514 Accents */
        .text-neon-green {
            color: #93F514;
            text-shadow: 0 0 20px rgba(147, 245, 20, 0.6);
        }
        .bg-neon-green {
            background-color: #93F514;
        }
        .glow-green {
            box-shadow: 0 0 35px -5px rgba(147, 245, 20, 0.45);
        }
        .glow-green-lg {
            box-shadow: 0 0 80px -10px rgba(147, 245, 20, 0.55);
        }
        .border-neon-green {
            border-color: rgba(147, 245, 20, 0.4);
            box-shadow: 0 0 15px rgba(147, 245, 20, 0.2);
        }
        .bg-mesh-dark {
            background-color: #040804;
        }

        /* Lightweight Page Entrance Animation */
        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-page-fade {
            animation: pageFadeIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes pulseGlow {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.08); opacity: 1; filter: drop-shadow(0 0 16px rgba(147, 245, 20, 0.8)); }
        }
        .animate-brand-pulse {
            animation: pulseGlow 1.2s ease-in-out infinite;
        }

        /* ============================================================
           LIGHT MODE OVERRIDES
           Aktif ketika <html> memiliki class "light-mode"
        ============================================================ */

        /* --- Body & Page Background --- */
        html.light-mode body {
            background-color: #F1F5F1 !important;
            color: #111827 !important;
        }

        /* --- Loader Overlay --- */
        html.light-mode .fixed.inset-0.z-\[100\] {
            background-color: #F1F5F1 !important;
        }

        /* --- Footer: TETAP GELAP untuk kontras premium --- */
        /* (Footer tidak perlu override, warna gelap aslinya tampil bagus di light mode) */

        /* --- Navbar scrolled (pill) --- */
        html.light-mode header .rounded-full[class*="bg-"] {
            background-color: rgba(255, 255, 255, 0.96) !important;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10), 0 1px 4px rgba(0,0,0,0.06) !important;
        }
        /* Mobile drawer */
        html.light-mode header .rounded-3xl[class*="bg-"] {
            background-color: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 8px 40px rgba(0,0,0,0.14) !important;
        }
        /* Navbar non-scrolled border */
        html.light-mode header .border-b {
            border-color: rgba(0, 0, 0, 0.07) !important;
        }

        /* =====================================================
           BACKGROUND UTILITIES: dark → light
        ===================================================== */

        /* Body / page surface */
        html.light-mode .bg-\[\#040804\]  { background-color: #F1F5F1 !important; }

        /* Footer bg: BIARKAN GELAP — tidak di-override */
        /* html.light-mode .bg-\[\#020602\] → dibiarkan agar footer tetap dark */

        /* Section header banners → sage-green gradient feel */
        html.light-mode .bg-\[\#051c05\]  { background-color: #EFF8E6 !important; }
        html.light-mode .bg-\[\#072907\]  { background-color: #E4F5D6 !important; }
        html.light-mode .bg-\[\#031103\]  { background-color: #F4FDE8 !important; }

        /* Cards → putih bersih dengan shadow */
        html.light-mode .bg-\[\#061506\]  { background-color: #FFFFFF !important; }
        html.light-mode .bg-\[\#030803\]  { background-color: #FBFFFE !important; }
        html.light-mode .bg-\[\#030a03\]  { background-color: #FBFFFE !important; }
        html.light-mode .bg-\[\#050c05\]  { background-color: #FFFFFF !important; }

        /* Subtle surface & icon containers */
        html.light-mode .bg-\[\#050e05\]  { background-color: #F2FAE8 !important; }
        html.light-mode .bg-\[\#051205\]  { background-color: #EBF7D8 !important; }
        html.light-mode .bg-\[\#041404\]  { background-color: #E4F5C8 !important; }
        html.light-mode .bg-\[\#061806\]  { background-color: #EBF7D8 !important; }

        /* Active/selected company card */
        html.light-mode .bg-\[\#0a2e0a\]  { background-color: #CCEFAA !important; }

        /* "Cari Lowongan" submit button: warna neon green #93F514 + teks & icon hitam */
        html.light-mode .bg-\[\#051405\] {
            background-color: #93F514 !important;
            color: #000000 !important;
            border-color: #93F514 !important;
            box-shadow: 0 4px 18px rgba(147, 245, 20, 0.45) !important;
        }
        html.light-mode .bg-\[\#051405\]:hover {
            background-color: #7edc0b !important;
            border-color: #7edc0b !important;
            color: #000000 !important;
            box-shadow: 0 6px 24px rgba(147, 245, 20, 0.65) !important;
        }
        html.light-mode .bg-\[\#051405\] svg,
        html.light-mode .bg-\[\#051405\] span,
        html.light-mode .bg-\[\#051405\].text-\[\#EEEEEE\] {
            color: #000000 !important;
            stroke: #000000;
        }

        /* =====================================================
           GRADIENT OVERRIDES: from / via / to
           (Hanya gradient section header & card, BUKAN hero overlay)
        ===================================================== */

        /* Section header (page banner) gradients → sage lime */
        html.light-mode .from-\[\#051c05\] { --tw-gradient-from: #EFF8E6 var(--tw-gradient-from-position,) !important; }
        html.light-mode .from-\[\#072907\] { --tw-gradient-from: #E4F5D6 var(--tw-gradient-from-position,) !important; }
        html.light-mode .from-\[\#031103\] { --tw-gradient-from: #F4FDE8 var(--tw-gradient-from-position,) !important; }
        html.light-mode .via-\[\#072907\]  { --tw-gradient-via:  #DCF0C8 var(--tw-gradient-via-position,)  !important; }
        html.light-mode .to-\[\#031103\]   { --tw-gradient-to:   #F4FDE8 var(--tw-gradient-to-position,)   !important; }

        /* Card gradients → putih ke off-white */
        html.light-mode .from-\[\#061506\] {
            --tw-gradient-from: #FFFFFF var(--tw-gradient-from-position,) !important;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04) !important;
        }
        html.light-mode .from-\[\#061506\]:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.11), 0 2px 8px rgba(0,0,0,0.06) !important;
        }
        html.light-mode .from-\[\#030803\] { --tw-gradient-from: #FBFFFE var(--tw-gradient-from-position,) !important; }
        html.light-mode .from-\[\#030a03\] { --tw-gradient-from: #F2FAE8 var(--tw-gradient-from-position,) !important; }
        html.light-mode .to-\[\#030803\]   { --tw-gradient-to:   #F5FFF0 var(--tw-gradient-to-position,)   !important; }
        html.light-mode .to-\[\#030a03\]   { --tw-gradient-to:   #EFF8E5 var(--tw-gradient-to-position,)   !important; }
        html.light-mode .to-\[\#041404\]   { --tw-gradient-to:   #E4F5C8 var(--tw-gradient-to-position,)   !important; }

        /* Active company card gradient */
        html.light-mode .from-\[\#0a2e0a\] { --tw-gradient-from: #CCEFAA var(--tw-gradient-from-position,) !important; }

        /* =====================================================
           COMPANY MITRA CARDS (Temukan Lowongan Berdasarkan Perusahaan)
           Warna Putih Bersih (#FFFFFF)
        ===================================================== */
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030a03\] {
            background: #FFFFFF !important;
            background-image: none !important;
            border-color: rgba(45, 107, 0, 0.20) !important;
            box-shadow: 0 2px 14px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.03) !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030a03\]:hover {
            background: #FFFFFF !important;
            border-color: rgba(45, 107, 0, 0.50) !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.09), 0 2px 6px rgba(0, 0, 0, 0.04) !important;
        }

        /* Active Company Card */
        html.light-mode .bg-gradient-to-b.from-\[\#0a2e0a\].to-\[\#041404\] {
            background: #FFFFFF !important;
            background-image: none !important;
            border-color: #93F514 !important;
            box-shadow: 0 4px 16px rgba(147, 245, 20, 0.25) !important;
        }

        /* Logo box inside Company Card */
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030a03\] .w-14.h-14,
        html.light-mode .bg-gradient-to-b.from-\[\#0a2e0a\].to-\[\#041404\] .w-14.h-14 {
            background-color: #F8FAFC !important;
            border-color: rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
        }

        /* Company Card Texts */
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030a03\] h3,
        html.light-mode .bg-gradient-to-b.from-\[\#0a2e0a\].to-\[\#041404\] h3 {
            color: #111827 !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030a03\]:hover h3 {
            color: #2D6B00 !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030a03\] p,
        html.light-mode .bg-gradient-to-b.from-\[\#0a2e0a\].to-\[\#041404\] p {
            color: #4B5563 !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030a03\] .text-\[\#93F514\],
        html.light-mode .bg-gradient-to-b.from-\[\#0a2e0a\].to-\[\#041404\] .text-\[\#93F514\] {
            color: #2D6B00 !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030a03\] .border-t,
        html.light-mode .bg-gradient-to-b.from-\[\#0a2e0a\].to-\[\#041404\] .border-t {
            border-color: rgba(0, 0, 0, 0.06) !important;
        }

        /* =====================================================
           JOB CARDS (Main Listing Grid)
        ===================================================== */
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030803\] {
            background: #FFFFFF !important;
            background-image: none !important;
            border-color: rgba(45, 107, 0, 0.20) !important;
            box-shadow: 0 3px 18px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04) !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030803\]:hover {
            border-color: rgba(45, 107, 0, 0.5) !important;
            box-shadow: 0 8px 30px rgba(45, 107, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.06) !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030803\] h3 {
            color: #111827 !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030803\]:hover h3 {
            color: #2D6B00 !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#030803\] p {
            color: #4B5563 !important;
        }

        /* Stats mini card (from-[#061506] to-[#040804]) — to-[#040804] jangan dioverride
           karena itu juga dipakai hero overlay. Override via bg class sudah cukup. */

        /* =====================================================
           TEXT COLORS
        ===================================================== */

        /* Primary text: gelap dan tajam */
        html.light-mode .text-\[\#EEEEEE\]  { color: #111827 !important; }
        html.light-mode .text-gray-200      { color: #374151 !important; }
        html.light-mode .text-gray-300      { color: #4B5563 !important; }
        html.light-mode .text-gray-400      { color: #6B7280 !important; }
        html.light-mode .text-gray-500      { color: #374151 !important; }

        /* Accent text: #93F514 terlalu terang di bg putih → gelapkan */
        html.light-mode .text-\[\#93F514\]  { color: #3D7A00 !important; }

        /* Footer text: biarkan tetap terang (footer background tetap gelap) */
        html.light-mode footer .text-\[\#EEEEEE\]  { color: #EEEEEE !important; }
        html.light-mode footer .text-gray-300      { color: #D1D5DB !important; }
        html.light-mode footer .text-gray-400      { color: #9CA3AF !important; }
        html.light-mode footer .text-gray-500      { color: #6B7280 !important; }
        html.light-mode footer .text-\[\#93F514\]  { color: #93F514 !important; }

        /* Gradient text heading (from-[#93F514]) → gelapkan untuk header biasa */
        html.light-mode .from-\[\#93F514\] { --tw-gradient-from: #3D7A00 var(--tw-gradient-from-position,) !important; }

        /* =====================================================
           BORDERS & DIVIDERS
        ===================================================== */
        html.light-mode .border-\[\#EEEEEE\]\/10         { border-color: rgba(0,0,0,0.07) !important; }
        html.light-mode .divide-\[\#EEEEEE\]\/10 > * + * { border-color: rgba(0,0,0,0.07) !important; }

        /* Green border: naikkan opacity agar terlihat di bg putih */
        html.light-mode .border-\[\#93F514\]\/30 { border-color: rgba(61,122,0,0.30) !important; }
        html.light-mode .border-\[\#93F514\]\/40 { border-color: rgba(61,122,0,0.40) !important; }

        /* Footer borders: biarkan tetap seperti dark mode */
        html.light-mode footer .border-\[\#93F514\]\/30 { border-color: rgba(147,245,20,0.25) !important; }
        html.light-mode footer .border-\[\#93F514\]\/20 { border-color: rgba(147,245,20,0.20) !important; }

        /* =====================================================
           SHADOWS (lebih subtle di bg terang)
        ===================================================== */
        html.light-mode .shadow-black\/80   { box-shadow: 0 8px 32px rgba(0,0,0,0.12) !important; }
        html.light-mode .shadow-black\/40   { box-shadow: 0 4px 16px rgba(0,0,0,0.08) !important; }
        html.light-mode .shadow-black\/25   { box-shadow: 0 2px 12px rgba(0,0,0,0.07) !important; }
        html.light-mode .shadow-2xl.shadow-black\/80 { box-shadow: 0 12px 40px rgba(0,0,0,0.14) !important; }

        /* =====================================================
           HERO SECTION — Gradasi Putih + Teks Kontras
        ===================================================== */

        /* Hero section bg → putih agar gradasi blend ke body */
        html.light-mode section.bg-\[\#040804\] {
            background-color: #F1F5F1 !important;
        }

        /* Hero gradient overlays → PUTIH (menggantikan gelap) */
        html.light-mode .bg-gradient-to-b.from-\[\#040804\]\/60 {
            background: linear-gradient(to bottom,
                rgba(241,245,241,0.55) 0%,
                rgba(241,245,241,0.35) 40%,
                rgba(241,245,241,0.95) 100%) !important;
        }
        html.light-mode .bg-black\/35 {
            background-color: rgba(255,255,255,0.25) !important;
        }
        html.light-mode .bg-\[radial-gradient\(ellipse_at_center\,_transparent_40\%\,_\#040804_95\%\)\] {
            background: radial-gradient(ellipse at center, transparent 30%, rgba(241,245,241,0.85) 90%) !important;
        }

        /* Ambient green glow → hide in light mode (noisy on white) */
        html.light-mode .bg-\[\#93F514\]\/15.blur-\[100px\] {
            opacity: 0 !important;
        }

        /* Hero heading "Temukan Karir Impian" — hitam tebal */
        html.light-mode section h1.text-\[\#EEEEEE\] {
            color: #0F1F0F !important;
            text-shadow: none !important;
            -webkit-text-stroke: 0 !important;
        }

        /* Hero subtitle "Bergabunglah bersama ribuan..." — gelap terbaca */
        html.light-mode section p.text-gray-200 {
            color: #374151 !important;
            text-shadow: none !important;
        }

        /* Hero text span "Wujudkan Potensi Terbaikmu" — Solid Neon Green #93F514 (Tanpa Gradasi) + Jelas */
        html.light-mode section h1 .bg-gradient-to-r.from-\[\#93F514\] {
            background: none !important;
            background-image: none !important;
            -webkit-background-clip: unset !important;
            background-clip: unset !important;
            -webkit-text-fill-color: #93F514 !important;
            color: #93F514 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.85), 0 0 14px rgba(147, 245, 20, 0.45) !important;
            filter: none !important;
        }
        /* Override via/to gradient vars for this span */
        html.light-mode section h1 .via-\[\#75f06a\] {
            --tw-gradient-via: transparent !important;
        }
        html.light-mode section h1 .to-\[\#5FE6B6\] {
            --tw-gradient-to: transparent !important;
        }

        /* Hero drop-shadow remove di light mode */
        html.light-mode .drop-shadow-\[0_4px_16px_rgba\(0\,0\,0\,0\.8\)\] {
            filter: none !important;
        }
        html.light-mode .drop-shadow-\[0_2px_8px_rgba\(0\,0\,0\,0\.9\)\] {
            filter: none !important;
        }
        html.light-mode .drop-shadow-\[0_0_25px_rgba\(147\,245\,20\,0\.4\)\] {
            filter: none !important;
        }

        /* Hero background image — brighten di light mode */
        html.light-mode section .filter.brightness-90 {
            filter: brightness(1.1) contrast(0.95) saturate(0.8) !important;
        }

        /* =====================================================
           STATS CARDS — Putih + Border Hijau + Shadow
           (Lowongan Aktif, Perusahaan Mitra, dll)
        ===================================================== */

        /* Stats cards: bg putih, border hijau gelap solid, shadow nyata */
        html.light-mode .border-\[\#93F514\]\/30.hover\:border-\[\#93F514\]\/60 {
            background: #FFFFFF !important;
            border-color: rgba(45,107,0,0.35) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04) !important;
        }
        html.light-mode .border-\[\#93F514\]\/30.hover\:border-\[\#93F514\]\/60:hover {
            border-color: rgba(45,107,0,0.6) !important;
            box-shadow: 0 6px 24px rgba(0,0,0,0.09), 0 2px 8px rgba(0,0,0,0.04) !important;
        }

        /* Stats number (3+, 4+, 5+, 9+) — gelap tebal */
        html.light-mode .border-\[\#93F514\]\/30.hover\:border-\[\#93F514\]\/60 .text-\[\#EEEEEE\] {
            color: #0F1F0F !important;
        }

        /* Stats label — hijau gelap readable */
        html.light-mode .border-\[\#93F514\]\/30.hover\:border-\[\#93F514\]\/60 .text-\[\#93F514\] {
            color: #2D6B00 !important;
        }

        /* Stats border-top separator */
        html.light-mode .border-t.border-\[\#93F514\]\/20 {
            border-color: rgba(45,107,0,0.18) !important;
        }

        /* =====================================================
           POPULAR SEARCH TAGS — Kontras di bg terang
        ===================================================== */
        html.light-mode .bg-\[\#051205\] {
            background-color: #FFFFFF !important;
            border-color: rgba(45,107,0,0.25) !important;
        }
        html.light-mode .bg-\[\#051205\]:hover {
            background-color: #EBF7D8 !important;
        }

        /* =====================================================
           SHOWCASE / CAROUSEL SECTION
           (Big dark rounded card with company photos)
        ===================================================== */

        /* Main carousel container bg → putih bersih */
        html.light-mode .bg-gradient-to-b.from-\[\#040804\].via-\[\#051405\].to-\[\#040804\] {
            background: linear-gradient(to bottom, #FFFFFF, #F7FAF4, #FFFFFF) !important;
            border-color: rgba(45,107,0,0.25) !important;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04) !important;
        }

        /* Carousel dot pattern overlay → hide di light mode */
        html.light-mode .opacity-\[0\.07\] {
            opacity: 0.03 !important;
        }

        /* Carousel ambient glow blobs → hide */
        html.light-mode .bg-\[\#93F514\]\/10.blur-\[100px\],
        html.light-mode .bg-\[\#93F514\]\/10.blur-\[90px\] {
            opacity: 0 !important;
        }

        /* Carousel concentric circle borders → subtle */
        html.light-mode .border-\[\#93F514\]\/15 { border-color: rgba(45,107,0,0.08) !important; }
        html.light-mode .border-\[\#93F514\]\/10 { border-color: rgba(45,107,0,0.05) !important; }
        html.light-mode .border-\[\#93F514\]\/5  { border-color: rgba(45,107,0,0.03) !important; }

        /* Carousel "Kunjungi Website" button → kontras di bg putih */
        html.light-mode .bg-white\/5 {
            background-color: rgba(45,107,0,0.06) !important;
        }
        html.light-mode .bg-white\/5:hover,
        html.light-mode .hover\:bg-white\/10:hover {
            background-color: rgba(45,107,0,0.12) !important;
        }

        /* Carousel photo frame borders → softer */
        html.light-mode .border-white\/20 { border-color: rgba(0,0,0,0.08) !important; }
        html.light-mode .border-white\/25 { border-color: rgba(0,0,0,0.10) !important; }

        /* Carousel photo bg container */
        html.light-mode .bg-black\/40 { background-color: rgba(0,0,0,0.05) !important; }

        /* Floating glass badge in carousel */
        html.light-mode .bg-\[\#061806\]\/85 {
            background-color: rgba(255,255,255,0.95) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
        }

        /* Carousel nav buttons */
        html.light-mode .bg-\[\#061506\].hover\:bg-\[\#93F514\] {
            background-color: #FFFFFF !important;
            border-color: rgba(45,107,0,0.30) !important;
        }
        html.light-mode .bg-\[\#061506\].hover\:bg-\[\#93F514\]:hover {
            background-color: #93F514 !important;
        }

        /* Progress bar bg */
        html.light-mode .bg-white\/10 { background-color: rgba(45,107,0,0.10) !important; }
        html.light-mode .hover\:bg-white\/20:hover { background-color: rgba(45,107,0,0.18) !important; }

        /* =====================================================
           ALUR PENDAFTARAN & SELEKSI
        ===================================================== */

        /* Step tab switcher container */
        html.light-mode .bg-\[\#061206\] {
            background-color: #FFFFFF !important;
            border-color: rgba(45,107,0,0.20) !important;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06) !important;
        }

        /* Inactive step tab text */
        html.light-mode .bg-\[\#061206\] button {
            color: #4B5563 !important;
            background: transparent !important;
        }
        html.light-mode .bg-\[\#061206\] button:hover {
            color: #111827 !important;
            background-color: rgba(0, 0, 0, 0.04) !important;
        }

        /* Active step tab button (e.g. 1. Registrasi Akun) → Solid Neon #93F514 + Text Hitam Pekat */
        html.light-mode .bg-\[\#061206\] button.font-extrabold,
        html.light-mode .bg-\[\#061206\] button[class*="from-\[\#93F514\]"] {
            background: #93F514 !important;
            background-image: none !important;
            color: #000000 !important;
            font-weight: 800 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12) !important;
        }

        /* Alur content card → putih + border hijau */
        html.light-mode .bg-gradient-to-b.from-\[\#071a07\].via-\[\#051105\].to-\[\#040804\] {
            background: linear-gradient(to bottom, #FFFFFF, #FBFFFE, #F7FAF4) !important;
            border-color: rgba(45,107,0,0.30) !important;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04) !important;
        }
        html.light-mode .from-\[\#071a07\] { --tw-gradient-from: #FFFFFF var(--tw-gradient-from-position,) !important; }
        html.light-mode .via-\[\#051105\]  { --tw-gradient-via: #FBFFFE var(--tw-gradient-via-position,)  !important; }

        /* Alur glow blob (top right) → hide */
        html.light-mode .bg-\[\#93F514\]\/15.blur-3xl {
            opacity: 0 !important;
        }

        /* =====================================================
           PAGE HEADER BANNER (Jelajahi Lowongan Pekerjaan)
        ===================================================== */
        html.light-mode .bg-gradient-to-r.from-\[\#051c05\].via-\[\#072907\].to-\[\#031103\] {
            background: #FFFFFF !important;
            background-image: none !important;
            border-color: rgba(45, 107, 0, 0.20) !important;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 1px 4px rgba(0, 0, 0, 0.04) !important;
        }

        /* Hide glow in Jelajahi Lowongan header */
        html.light-mode .bg-gradient-to-r.from-\[\#051c05\].via-\[\#072907\].to-\[\#031103\] .blur-3xl {
            opacity: 0 !important;
        }

        /* Heading text "Jelajahi" in light mode */
        html.light-mode .bg-gradient-to-r.from-\[\#051c05\].via-\[\#072907\].to-\[\#031103\] h1.text-\[\#EEEEEE\] {
            color: #111827 !important;
        }

        /* Span "Lowongan Pekerjaan" in light mode -> deep emerald green #2D6B00 */
        html.light-mode .bg-gradient-to-r.from-\[\#051c05\].via-\[\#072907\].to-\[\#031103\] h1 span {
            background: none !important;
            background-image: none !important;
            -webkit-background-clip: unset !important;
            background-clip: unset !important;
            -webkit-text-fill-color: #2D6B00 !important;
            color: #2D6B00 !important;
            font-weight: 800 !important;
        }

        /* Description subtitle text */
        html.light-mode .bg-gradient-to-r.from-\[\#051c05\].via-\[\#072907\].to-\[\#031103\] p.text-gray-300 {
            color: #4B5563 !important;
        }

        /* =====================================================
           KATEGORI DEPARTEMEN CARDS
        ===================================================== */

        /* Department card → putih + border + shadow */
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#040804\].border-\[\#93F514\]\/30 {
            background: #FFFFFF !important;
            border-color: rgba(45,107,0,0.22) !important;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.04) !important;
        }
        html.light-mode .bg-gradient-to-b.from-\[\#061506\].to-\[\#040804\].border-\[\#93F514\]\/30:hover {
            border-color: rgba(45,107,0,0.5) !important;
            box-shadow: 0 8px 28px rgba(45,107,0,0.12), 0 2px 6px rgba(0,0,0,0.06) !important;
        }

        /* Department card icon container */
        html.light-mode .bg-\[\#93F514\]\/15.border-\[\#93F514\]\/40 {
            background-color: rgba(45,107,0,0.08) !important;
            border-color: rgba(45,107,0,0.25) !important;
        }

        /* =====================================================
           CTA BANNER ("Siap Memulai Karir Baru Bersama Kami?")
           Warna Putih Bersih (#FFFFFF)
        ===================================================== */
        html.light-mode .bg-gradient-to-r.from-\[\#041a04\].via-\[\#062906\].to-\[\#031203\] {
            background: #FFFFFF !important;
            background-image: none !important;
            border-color: rgba(45, 107, 0, 0.20) !important;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 1px 4px rgba(0, 0, 0, 0.03) !important;
        }

        /* CTA banner heading & text */
        html.light-mode .bg-gradient-to-r.from-\[\#041a04\] h2.text-\[\#EEEEEE\],
        html.light-mode .bg-gradient-to-r.from-\[\#041a04\] .text-\[\#EEEEEE\] {
            color: #111827 !important;
        }
        html.light-mode .bg-gradient-to-r.from-\[\#041a04\] p.text-gray-300,
        html.light-mode .bg-gradient-to-r.from-\[\#041a04\] .text-gray-300 {
            color: #4B5563 !important;
        }

        /* CTA "Daftar Akun Sekarang" button: Solid #93F514 + Text Hitam + Tanpa Glowing Shadow */
        html.light-mode .bg-gradient-to-r.from-\[\#041a04\] a.bg-gradient-to-r.from-\[\#93F514\] {
            background: #93F514 !important;
            background-image: none !important;
            color: #000000 !important;
            border: 1px solid #93F514 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12) !important;
        }
        html.light-mode .bg-gradient-to-r.from-\[\#041a04\] a.bg-gradient-to-r.from-\[\#93F514\]:hover {
            background: #7edc0b !important;
            border-color: #7edc0b !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.16) !important;
        }

        /* CTA "Masuk Akun" button: Putih + Border Halus */
        html.light-mode .bg-gradient-to-r.from-\[\#041a04\] a.bg-black\/50 {
            background-color: #FFFFFF !important;
            color: #111827 !important;
            border-color: rgba(147, 245, 20, 0.40) !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
        }
        html.light-mode .bg-gradient-to-r.from-\[\#041a04\] a.bg-black\/50:hover {
            background-color: #E8F6DC !important;
            border-color: #93F514 !important;
        }

        /* =====================================================
           MISC
        ===================================================== */
        html.light-mode .placeholder-gray-400::placeholder { color: #9ca3af !important; }
        html.light-mode .hover\:bg-\[\#EEEEEE\]\/5:hover   { background-color: rgba(0,0,0,0.04) !important; }

        /* =====================================================
           THEME TOGGLE BUTTON
        ===================================================== */
        .theme-toggle-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 9999px;
            border: 1.5px solid rgba(147, 245, 20, 0.4);
            background: rgba(147, 245, 20, 0.08);
            color: #93F514;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s, transform 0.2s;
            flex-shrink: 0;
        }
        .theme-toggle-btn:hover {
            background: rgba(147, 245, 20, 0.18);
            border-color: #93F514;
            transform: scale(1.08);
        }
        html.light-mode .theme-toggle-btn {
            background: rgba(61, 122, 0, 0.10);
            color: #3D7A00;
            border-color: rgba(61, 122, 0, 0.35);
        }
        html.light-mode .theme-toggle-btn:hover {
            background: rgba(61, 122, 0, 0.18);
            border-color: #3D7A00;
        }
    </style>
</head>

<body class="antialiased bg-[#040804] text-[#EEEEEE] selection:bg-[#93F514] selection:text-black min-h-screen flex flex-col justify-between"
      x-data="{ pageLoaded: false }" 
      x-init="
          window.addEventListener('load', () => setTimeout(() => pageLoaded = true, 200));
          setTimeout(() => pageLoaded = true, 500);
      ">
    
    <!-- Lightweight Initial Page Loader Overlay (Smooth Rotating Neon Spinner) -->
    <div x-show="!pageLoaded" 
         x-transition:leave="transition ease-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 pointer-events-none"
         class="fixed inset-0 z-[100] bg-[#040804] flex flex-col items-center justify-center select-none">
        
        <div class="relative flex items-center justify-center">
            <!-- Subtle Glow behind spinner -->
            <div class="w-20 h-20 rounded-full bg-[#93F514]/30 blur-xl absolute"></div>
            
            <!-- Sleek Rotating Neon Green Spinner -->
            <div class="w-14 h-14 border-4 border-[#93F514]/20 border-t-[#93F514] rounded-full animate-spin"></div>
        </div>
    </div>

    <!-- Top Navigation Header -->
    @include('frontend.components.navbar')

    <!-- Main Content with smooth fade entrance -->
    <main class="flex-grow animate-page-fade">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.components.footer')

    @stack('scripts')

    {{-- Theme toggle logic (Alpine.js store) --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                isDark: localStorage.getItem('mika-theme') !== 'light',

                toggle() {
                    this.isDark = !this.isDark;
                    const html = document.getElementById('html-root');
                    if (this.isDark) {
                        html.classList.remove('light-mode');
                        localStorage.setItem('mika-theme', 'dark');
                    } else {
                        html.classList.add('light-mode');
                        localStorage.setItem('mika-theme', 'light');
                    }
                }
            });
        });
    </script>
</body>
</html>
