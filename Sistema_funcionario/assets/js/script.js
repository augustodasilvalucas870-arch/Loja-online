document.querySelector("form").addEventListener("submit", e => {
    if (!document.querySelector("[name=nome]").value) {
        alert("Nome é obrigatório");
        e.preventDefault();
    }
});
console.log("Sistema de Funcionários ativo");