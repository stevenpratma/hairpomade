<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Store</title>
    <!-- Include your CSS and JavaScript files here -->
    <link rel="stylesheet" href="path/to/your/styles.css">
    <script src="path/to/your/script.js" defer></script>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .social-media {
            display: flex;
            align-items: center;
        }
        .social-media .icons {
            margin-left: 10px;
        }
        .icons a {
            margin-right: 10px;
        }
        .search-container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="content">
        <!-- Add the image here -->
        <img src="asset/haripomade.jpeg" alt="Hair Pomade PKU Store" class="intro-y" width="300px">
        
        <h2 class="intro-y text-lg font-medium mt-10">
            Hair Pomade PKU Store
        </h2>
        <div class="mt-5">
            <p class="text-slate-500">
                Hair Pomade PKU yang berarti Pekanbaru. Toko Pomade ini sudah buka sejak 2013 menjual berbagai macam produk pomade lokal dan import di Pekanbaru. Hair Pomade PKU merupakan salah satu Pomade terbaik yang ada di Pekanbaru, Sebab menjual produk harga pomade yang standar dengan merk bagus kualitas yang terbaik.       
                Kunjungi Produk kita dengan mengklik <a href="<?= base_url('categories/fashion') ?>">di sini</a>.
            </p>
        </div>

        <!-- Jenis Jenis Pomade Section -->
        <div class="mt-5">
            <h2 class="intro-y text-lg font-medium">
                Jenis Jenis Pomade
            </h2>
            <p class="text-slate-500">
                1. Pomade Oil-Based : Pomade ini berbahan dasar minyak yang memberikan kilau yang tahan lama dan cocok untuk rambut kering.
            </p>
            <p class="text-slate-500">
                2. Pomade Water-Based : Lebih mudah dibersihkan dibandingkan dengan pomade berbahan dasar minyak, pomade ini memberikan tampilan yang lebih natural.
            </p>
            <p class="text-slate-500">
                3. Clay Pomade : Mengandung tanah liat yang memberikan tekstur lebih pada rambut dan cocok untuk gaya rambut yang lebih tebal.
            </p>
            <p class="text-slate-500">
                4. Powder Pomade : Berbahan Powder, Memberikan daya tahan yang kuat dan fleksibel, cocok untuk gaya rambut yang membutuhkan banyak kontrol.
            </p>
        </div>

        <!-- Search Form -->
        <!-- <div class="search-container">
            <input type="text" id="searchInput" placeholder="Cari produk...">
            <button onclick="searchProduct()">Cari</button>
        </div> -->

        <!-- Search Results -->
        <div id="searchResults" class="mt-5"></div>

        <!-- Add Sosial Media section here -->
        <div class="social-media">
            <div class="description">
                <p></p>
            </div>
            <div class="icons">
                <h2 class="intro-y text-lg font-medium mt-10">
                    Sosial Media
                </h2>
                <a class="btn btn-dark btn-social mx-2" href="https://www.tiktok.com/@hairpomade_pku?_t=8msNwnaveKu&_r=1"><i class="fab fa-tiktok"></i></a>
                <a class="btn btn-dark btn-social mx-2" href="https://www.facebook.com/profile.php?id=100054400622459&mibextid=rS40aB7S9Ucbxw6v"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-dark btn-social mx-2" href="https://www.instagram.com/hairpomade.pku?igsh=c25jOWw4MGtnZW5r"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <!-- Example footer, adjust as needed -->
        <footer>
            <p>&copy; 2024 Hair Pomade. All rights reserved.</p>
        </footer>
    </div>

    <script>
        const products = [
            { id: 1, name: 'Pomade A', description: 'Pomade lokal kualitas tinggi', price: 50000 },
            { id: 2, name: 'Pomade B', description: 'Pomade import harga terjangkau', price: 75000 },
            { id: 3, name: 'Pomade C', description: 'Pomade dengan aroma menyegarkan', price: 60000 },
            // Tambahkan produk lainnya di sini
        ];

        function searchProduct() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const results = products.filter(product => product.name.toLowerCase().includes(input));
            
            displayResults(results);
        }

        function displayResults(results) {
            const resultsContainer = document.getElementById('searchResults');
            resultsContainer.innerHTML = '';

            if (results.length > 0) {
                results.forEach(product => {
                    const productElement = document.createElement('div');
                    productElement.innerHTML = `<h3>${product.name}</h3><p>${product.description}</p><p>Price: Rp${product.price}</p>`;
                    resultsContainer.appendChild(productElement);
                });
            } else {
                resultsContainer.innerHTML = '<p>No products found.</p>';
            }
        }
    </script>
</body>

</html>
