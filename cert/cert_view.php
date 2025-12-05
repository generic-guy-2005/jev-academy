<!-- pinterest-masonry.html -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Attribution Gallery — Masonry</title>
    <style>
        :root {
            --gap: 1rem;
            --card-radius: 8px;
            --card-bg: #ffffff;
            --card-shadow: 0 6px 18px rgba(12, 15, 20, 0.06);
        }

        body {
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: #f5f7fb;
            margin: 0;
            color: #0f172a;
        }

        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        h1 {
            font-size: 1.4rem;
            margin: 0 0 1rem;
            font-weight: 600;
        }

        /* Masonry using CSS columns */
        .masonry {
            column-gap: var(--gap);
            /* number of columns changes with viewport width */
            columns: 1;
        }

        /* responsive columns */
        @media(min-width: 640px) {
            .masonry {
                columns: 2;
            }
        }

        @media(min-width: 900px) {
            .masonry {
                columns: 3;
            }
        }

        @media(min-width: 1200px) {
            .masonry {
                columns: 4;
            }
        }

        /* Each card must be inline-block to flow into columns correctly */
        .card {
            display: inline-block;
            width: 100%;
            margin: 0 0 var(--gap);
            break-inside: avoid;
            /* avoid splitting cards between columns */
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            vertical-align: top;
        }

        .card img {
            display: block;
            width: 100%;
            height: auto;
            /* keep natural aspect ratio */
        }

        .meta {
            padding: 0.6rem 0.8rem;
        }

        .title {
            font-size: 0.95rem;
            margin: 0 0 0.35rem;
            line-height: 1.2;
            font-weight: 600;
        }

        .attrib {
            font-size: 0.82rem;
            color: #475569;
            display: flex;
            gap: 0.5rem;
            align-items: center;
            justify-content: space-between;
        }

        .attrib a {
            color: #0ea5a4;
            text-decoration: none;
            font-weight: 500;
        }

        /* small overlay with icon-like attribution */
        .badge {
            font-size: 0.75rem;
            background: rgba(2, 6, 23, 0.06);
            padding: 0.18rem 0.45rem;
            border-radius: 999px;
        }

        /* hover lift */
        .card:hover {
            transform: translateY(-4px);
            transition: transform .18s ease;
            box-shadow: 0 10px 30px rgba(12, 15, 20, 0.10);
        }

    </style>
</head>

<body>
    <div class="container">
        <h1>Designs & Attribution</h1>

        <div class="masonry" id="masonry">
            <figure class="card">
                <img src="assets\breathtaking-view-snowy-mountains-cloudy-sky-patagonia-chile.jpg" alt="Sample design 1">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.freepik.com/author/wirestock" target="_blank" rel="noopener">wirestock</a></span>
                        <span class="badge">Freepik</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\renewable-energy.png" alt="Sample design 2">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/renewable-energy_2511490?term=renewable-energy&page=1&position=7&origin=search&related_id=2511490" target="_blank" rel="noopener">nawicon</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\piston.png" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/piston_3627903?term=piston&related_id=3627903" target="_blank" rel="noopener">wanicon</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\engineering.png" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/engineering_3002128?term=industry&page=1&position=63&origin=search&related_id=3002128" target="_blank" rel="noopener">Freepik</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\it-department.png" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/it-department_8740993?term=it+department&page=1&position=7&origin=search&related_id=8740993" target="_blank" rel="noopener">Iconjam</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\document.png" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/document_2976389?term=accounting&page=1&position=26&origin=search&related_id=2976389" target="_blank" rel="noopener">kerismaker</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\translating.png" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/translating_2104994?term=translate&page=1&position=9&origin=search&related_id=2104994" target="_blank" rel="noopener">photo3idea_studio</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\application.png" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/application_10348626?term=other&page=1&position=12&origin=search&related_id=10348626" target="_blank" rel="noopener">Anggara</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\children-studying-outdoors.jpg" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.freepik.com/free-photo/children-studying-outdoors_1193413.htm#fromView=search&page=1&position=13&uuid=437eb92f-2bf7-43fe-8ac0-f124d7140d5f&query=students" target="_blank" rel="noopener">freepik</a></span>
                        <span class="badge">Freepik</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\group-diverse-grads-throwing-caps-up-sky.jpg" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.freepik.com/free-photo/group-diverse-grads-throwing-caps-up-sky_3366984.htm#fromView=search&page=1&position=0&uuid=2d012fb3-1af4-4b26-aeb0-b0011572b59f&query=graduation" target="_blank" rel="noopener">rawpixel.com</a></span>
                        <span class="badge">Freepik</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\bailey-zindel-NRQV-hBF10M-unsplash.jpg" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.freepik.com/free-photo/group-diverse-grads-throwing-caps-up-sky_3366984.htm#fromView=search&page=1&position=0&uuid=2d012fb3-1af4-4b26-aeb0-b0011572b59f&query=graduation" target="_blank" rel="noopener">Bailey Zindel</a></span>
                        <span class="badge">Unsplash</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\kalen-emsley-Bkci_8qcdvQ-unsplash.jpg" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://unsplash.com/photos/green-mountain-across-body-of-water-Bkci_8qcdvQ?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText" target="_blank" rel="noopener">Kalen Emsley</a></span>
                        <span class="badge">Unsplash</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\mark-harpur-K2s_YE031CA-unsplash.jpg" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://unsplash.com/photos/brown-wooden-dock-between-lavender-flower-field-near-body-of-water-during-golden-hour-K2s_YE031CA?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText" target="_blank" rel="noopener">Mark Harpur</a></span>
                        <span class="badge">Unsplash</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\ales-krivec-4miBe6zg5r0-unsplash.jpg" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://unsplash.com/photos/photo-of-green-grass-field-at-sunrise-4miBe6zg5r0?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText" target="_blank" rel="noopener">Ales Krivec</a></span>
                        <span class="badge">Unsplash</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\simon-twukN12EN7c-unsplash.jpg" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://unsplash.com/photos/landscape-photography-of-mountains-twukN12EN7c?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText" target="_blank" rel="noopener">simon</a></span>
                        <span class="badge">Unsplash</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\shield.png" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/shield_1161388?term=shield&page=1&position=15&origin=search&related_id=1161388" target="_blank" rel="noopener">Freepik</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\magnifying-glass-white.png" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/magnifying-glass_151773?term=search&page=1&position=3&origin=search&related_id=151773" target="_blank" rel="noopener">Chanut</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>

            <figure class="card">
                <img src="assets\email.png" alt="Sample design 3">
                <figcaption class="meta">
                    <div class="attrib">
                        <span>by <a href="https://www.flaticon.com/free-icon/email_2099199?term=email&page=1&position=10&origin=search&related_id=2099199" target="_blank" rel="noopener">Freepik</a></span>
                        <span class="badge">Flaticon</span>
                    </div>
                </figcaption>
            </figure>
        </div>
    </div>
</body>

</html>