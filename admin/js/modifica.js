
function getAllArticles() {
    fetch('../api/index.php?op=backend&action=getEvent')
        .then(response => response.json())
        .then(data => {
            console.log("Données reçues:", data); 
            const articles = data.eventi;

            if (!Array.isArray(articles)) {
                throw new Error("Les données reçues ne sont pas un tableau !");
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
                                    <a href="modifica_evento?id=${article.id_evento}" data-id="${article.id_evento}"  class="btn btn-success btn-circle">
                                        <i class="fas fa-wrench"></i>
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
