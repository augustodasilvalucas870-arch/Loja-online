function finalizarCompra() {
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    if (carrinho.length === 0) {
        alert('Carrinho vazio');
        return;
    }

    fetch('api/checkout.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(carrinho)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Pedido criado com sucesso');
        } else {
            alert('Erro ao processar pedido');
        }
    });
}
