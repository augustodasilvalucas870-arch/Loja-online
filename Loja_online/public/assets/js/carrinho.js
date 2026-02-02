function carregarCarrinho() {
    const container = document.getElementById("cart-content");
    const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

    if (carrinho.length === 0) {
        container.innerHTML = `
            <div class="cart-empty">
                <p><strong>O seu carrinho está vazio.</strong></p>
                <span>Parece que ainda não tomou uma decisão.</span>
                <a href="index.php#produtos" class="btn-primary">
                    Continuar a comprar
                </a>
            </div>
        `;
        document.getElementById("cart-total").innerText = "0 Kz";
        return;
    }

    let html = `
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Preço</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    `;

    let total = 0;

    carrinho.forEach((p, index) => {
        const subtotal = p.preco * p.quantidade;
        total += subtotal;

        html += `
            <tr>
                <td>${p.nome}</td>
                <td>${p.quantidade}</td>
                <td>${subtotal.toLocaleString()} Kz</td>
                <td>
                    <button onclick="removerItem(${index})">❌</button>
                </td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    container.innerHTML = html;
    document.getElementById("cart-total").innerText = total.toLocaleString() + " Kz";
}

function removerItem(index) {
    let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
    carrinho.splice(index, 1);
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    carregarCarrinho();
}

function finalizarCompra() {
    alert("Compra finalizada (simulação).");
    localStorage.removeItem("carrinho");
    carregarCarrinho();
}

document.addEventListener("DOMContentLoaded", carregarCarrinho);

function adicionarCarrinho(id, nome, preco) {
    fetch("carrinho.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, nome, preco })
    })
    .then(res => res.json())
    .then(data => alert(data.mensagem));
}
