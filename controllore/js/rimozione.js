function getAllArticles() {
    fetch('../api/backend')
        .then(response => response.json())
        .then(data => {
            const articles = data.eventi;

            if (!Array.isArray(articles)) {
                throw new Error("I dati ricevuti non sono validi !");
            }
            const container = document.getElementById("getEvent");
            container.innerHTML = ""; 

            articles.forEach((article) => { 
                const articleHTML = `
                     <tr>
                           <td><img src="../img/${article.immagine}" style="width: 120px; height: 80px; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);" alt="Aperçu de l'événement"></td>      
                           <td>${article.titolo}</td>
                           <td>${article.descrizione}</td>
                           <td>${article.luogo_svolgimento}</td>
                           <td>${article.data_svolgimento}</td>
                           <td>${article.data_creazione}</td>
                            <td><div class="card-body">
                            <a href="#" data-id="${article.id_evento}" onclick="return cancellare_evento(this);" class="btn btn-danger btn-circle">
                                 <i class="fas fa-trash"></i>
                            </a></div></td>
                    </tr>
                   
                `;

                container.innerHTML += articleHTML;
            });
        })
        .catch(error => console.error("Erreur:", error));
}
    getAllArticles();

   setInterval(getAllArticles, 5000);

   function cancellare_evento(element) {
    let articleId = element.getAttribute("data-id"); 

    if (!confirm(`Vuole veramente cancellare l'evento #${articleId} ?`)) {
        return false; 
    }

    fetch(`../api/evento/${articleId}`, { 
        method: 'DELETE',
        headers: { "Content-Type": "application/json" }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Errore durante la suppressione");
        }
        return response.json();
    })
    .then(data => {
        alert(`Evento #${articleId} cancellato con successo !`);
        
        element.parentElement.remove(); 
    })
    .catch(error => {
        alert("Erreur : " + error.message);
    });

    return false; 
}
