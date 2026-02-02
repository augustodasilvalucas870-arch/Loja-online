<?php
require "../app/config/database.php";
$produtos = $pdo->query("SELECT * FROM produtos")->fetchAll();

?>



<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/Loja_online/public/assets/css/style.css">
</head>
<body>
<header class="header">
    <div class="logo">Loja<span>Online</span></div>
    
   <?php session_start(); ?>


  <nav class="nav-links">
    
    <a href="#inicio">Início</a>

    <a href="/Loja_online/public/produto.php">Produtos</a>

    
    <?php if (isset($_SESSION['user'])): ?>
        <span class="user-name">
            Olá, <?= htmlspecialchars($_SESSION['user']['nome']) ?>
        </span>

        <a href="logout.php" class="btn-outline">
            Logout
        </a>
    <?php else: ?>
        <a href="login.php" class="btn-login">
            Login
        </a>
      <?php endif; ?>

        <a href="carrinho.php" class="btn-outline">
        Carrinho (<span id="cart-count">0</span>)
        </a>

</nav>

</header>

<section class="hero-slider" id="inicio">

    <div class="slide active" style="background-image: url('assets/images/slider/tecnologia.jpeg');">
        <div class="hero-text">
            <h1>Compras inteligentes começam aqui</h1>
            <p>Produtos modernos, preços acessíveis e pagamento seguro.</p>
            <button class="btn-explorar" onclick="irParaProdutos()">Explorar produtos</button>
        </div>
    </div>

    <div class="slide" style="background-image: url('assets/images/slider/holograma-de-tecnologia-futurista.jpg');">
        <div class="hero-text">
            <h1>Tecnologia de última geração</h1>
            <p>Encontra os melhores acessórios tecnológicos.</p>
            <button class="btn-explorar" onclick="irParaProdutos()">Ver produtos</button>
        </div>
    </div>

    <div class="slide" style="background-image: url('assets/images/slider/pagamento.jpg');">
        <div class="hero-text">
            <h1>Pagamentos rápidos e seguros</h1>
            <p>PayPal e Multicaixa Express disponíveis.</p>
            <button class="btn-explorar" onclick="irParaProdutos()">Comprar agora</button>
        </div>
    </div>

</section>

<section id="produtos" class="produtos">
    <!-- Cards de produtos -->

<h2 style="margin-bottom:30px;">Produtos em destaque</h2>

    <div class="grid">
        <?php foreach ($produtos as $p): ?>

            <div class="card">
                <img 
                    src="/Loja_online/<?= htmlspecialchars($p['imagem']) ?>" 
                    alt="<?= htmlspecialchars($p['nome']) ?>">

                <h3><?= htmlspecialchars($p['nome']) ?></h3>

                <p><?= number_format($p['preco'], 0, ',', '.') ?> Kz</p>

               <button onclick="adicionarAoCarrinho(
               <?= $p['id'] ?>,
               '<?= htmlspecialchars($p['nome'], ENT_QUOTES) ?>',
                <?= $p['preco'] ?>,
                '<?= htmlspecialchars($p['imagem'], ENT_QUOTES) ?>'
                )">
                Adicionar ao carrinho
               </button>

            </div>
    
        <?php endforeach; ?>
    </div>

</section>

<script src="/Loja_online/public/assets/js/produtos.js"></script>
<script src="/Loja_online/public/assets/js/slider.js"></script>


</body>
</html>
