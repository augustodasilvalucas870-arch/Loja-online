function adicionarAoCarrinho(id, nome, preco, imagem) {
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    id = String(id);
    preco = Number(preco);

    const produto = carrinho.find(p => String(p.id) === id);

    if (produto) {
        produto.quantidade++;
    } else {
        carrinho.push({
            id,
            nome,
            preco,
            imagem,
            quantidade: 1
        });
    }

    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarCarrinhoBadge();
    alert('Produto adicionado ao carrinho');
}

function atualizarCarrinhoBadge() {
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    const total = carrinho.reduce((s, p) => s + p.quantidade, 0);

    const badge = document.getElementById('cart-count');
    if (badge) badge.innerText = total;
}

document.addEventListener('DOMContentLoaded', atualizarCarrinhoBadge);

function irParaProdutos() {
    document.getElementById('produtos').scrollIntoView({
        behavior: 'smooth'
    });
}