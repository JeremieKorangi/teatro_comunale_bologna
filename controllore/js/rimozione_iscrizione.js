function getAllArticles() {
    fetch('../api/backend?action=eventi_iscritti')
        .then(response => response.json())
        .then(articles => {
            const container = document.getElementById("getEvent");
            container.innerHTML = ""; 

            articles.forEach((article) => { 
                const articleHTML = `
                    <tr data-id="${article.id_evento}">
                        <td><img src="../img/${article.immagine}" style="width: 120px; height: 80px; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);" alt="Aperçu de l'événement"></td>      
                        <td>${article.titolo}</td>
                        <td>${article.descrizione}</td>
                        <td>
                            <div class="card-body">
                                <a href="#" class="btn btn-danger btn-circle cancellare-evento" data-id="${article.id_evento}">
                                    <i class="fas fa-ban"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
                container.innerHTML += articleHTML;
            });

            document.querySelectorAll(".cancellare-evento").forEach(btn => {
                btn.addEventListener("click", function (event) {
                    event.preventDefault(); 
                    cancellare_evento(this);
                });
            });
        })
        .catch(error => console.error("Erreur:", error));
}

getAllArticles();
setInterval(getAllArticles, 5000);

function cancellare_evento(element) {
    let articleId = element.getAttribute("data-id"); 

    if (!confirm("Vuole veramente cancellare l'iscrizione all'evento selezionato ?")) {
        return;
    }

    fetch(`../api/backend?id=${articleId}&action=delete_iscrizione`, { 
        method: 'DELETE',
        headers: { "Content-Type": "application/json" }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur lors de la suppression");
        }
        return response.json();
    })
    .then(() => {
        alert("Iscrizione cancellata con successo !");
                const rowToDelete = element.closest("tr");
        if (rowToDelete) rowToDelete.remove();
    })
    .catch(error => {
        alert("Erreur : " + error.message);
    });
}

