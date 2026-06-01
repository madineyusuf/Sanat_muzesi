<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanat Müzesi </title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            --museum-dark: #1a1a1a;
            --museum-gold: #c5a880;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fcfbf9; 
            color: #333333;
        }

      
        .museum-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

      
        .navbar-museum {
            background-color: var(--museum-dark);
            border-bottom: 3px solid var(--museum-gold);
            padding: 1rem 0;
        }

        .navbar-museum .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            letter-spacing: 1px;
            color: #ffffff;
        }

        .navbar-museum .navbar-brand span {
            color: var(--museum-gold);
        }

        .navbar-museum .nav-link {
            color: #e0e0e0;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .navbar-museum .nav-link:hover {
            color: var(--museum-gold);
        }

       
        .museum-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff;
        }

        .museum-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06) !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-museum mb-5 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="eserler.php">SANAT <span>MÜZESİ</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item px-2">
          <a class="nav-link" href="eserler.php">Koleksiyon</a>
        </li>
        <li class="nav-item px-2">
          <a class="nav-link" href="eser-ekle.php">Yeni Eser Ekle</a>
        </li>
        <li class="nav-item ps-3">
          <a class="btn btn-outline-light btn-sm px-3" style="border-color: #ff4d4d; color: #ff4d4d;" href="logout.php">Çıkış Yap</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container container-main">