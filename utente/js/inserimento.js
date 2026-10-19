document.getElementById("articleForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Empêche le rechargement de la page

     // Mettre à jour la valeur du textarea avec le contenu de TinyMCE
     tinymce.triggerSave(); 

    let formData = new FormData();
    formData.append("title", document.getElementById("titolo").value);
    formData.append("luogo", document.getElementById("luogo").value);
    formData.append("hashtag", document.getElementById("hashtag").value);
    formData.append("datetime", document.getElementById("datetime").value);
    formData.append("descrizione", document.getElementById("descrizione").value);
    formData.append("hashtag", document.getElementById("hashtag").value);

    
    let imageInput = document.getElementById("image");
    if (imageInput.files.length > 0) {
        formData.append("image", imageInput.files[0]); 
    }

    fetch("../api/index.php?op=evento", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("L'evento è stato aggiunto con successo !");
            document.getElementById("articleForm").reset();
        } else {
            alert("Erreur : " + data.message);
        }
    })
    .catch(error => console.error("Erreur:", error));
});
