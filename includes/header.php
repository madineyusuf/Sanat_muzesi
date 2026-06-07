<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanat Müzesi Arşivi</title>
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
     
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f0f11;
            color: #f3f4f6;
            letter-spacing: -0.2px;
        }

    
        .navbar-classicals {
            background-color: #16161a; 
            border-bottom: 1px solid #232329; 
            padding: 0.8rem 0;
        }

        .navbar-classicals .navbar-brand {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            color: #ffffff !important;
        }

        .navbar-classicals .nav-link {
            color: #9ca3af !important; 
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .navbar-classicals .nav-link:hover {
            color: #ffffff !important; 
        }

      
        .museum-card {
            border: 1px solid #232329 !important;
            border-radius: 8px;
            background-color: #16161a !important;
            transition: border-color 0.2s ease, transform 0.2s ease;
        }

        .museum-card:hover {
            border-color: #4b5563 !important; 
            transform: translateY(-2px);
        }

  
        .text-muted-custom {
            color: #9ca3af !important;
        }
        
        .badge-archive {
            background-color: #232329;
            color: #9ca3af;
            border: 1px solid #374151;
            font-weight: 500;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-classicals mb-5 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="eserler.php">MUSEUM // ARCHIVE</a>
    <button class="navbar-toggler navbar-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item px-2">
          <a class="nav-link" href="eserler.php">Koleksiyon</a>
        </li>
        <li class="nav-item px-2">
          <a class="nav-link" href="eser-ekle.php">Eser Ekle</a>
        </li>
        <li class="nav-item ps-3">
          <a class="nav-link text-danger px-2" style="font-size: 0.85rem;" href="logout.php">[ Çıkış ]</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
