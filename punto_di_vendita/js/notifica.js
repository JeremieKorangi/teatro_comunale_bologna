        async function fetchNotifications() {
    try {
        let response = await fetch("../api/notifica"); // Remplace avec l'URL correcte de ton API
        let data = await response.json();

        let notificationBadge = document.querySelector(".badge-counter");
        let notificationDropdown = document.querySelector(".dropdown-list");

        // Vider les anciennes notifications
        notificationDropdown.innerHTML = `
            <h6 class="dropdown-header">Notifiche</h6>
        `;

        if (data.length > 0) {
            // Mettre à jour le badge avec le nombre de notifications
            notificationBadge.textContent = data.length;
            notificationBadge.style.display = "inline-block"; // Afficher le badge

            // Générer la liste des notifications
            data.forEach(notif => {
                let notifItem = document.createElement("a");
                notifItem.classList.add("dropdown-item", "d-flex", "align-items-center");
                notifItem.href = `../show_evento?id=${notif.evento}&action=view`;

                notifItem.innerHTML = `
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-bell text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">${new Date(notif.data_creazione).toLocaleString()}</div>
                        <span class="font-weight-bold">${notif.descrizione}</span>
                    </div>
                `;

                notificationDropdown.appendChild(notifItem);
            });
        } else {
            // Si aucune notification, afficher un message
            notificationBadge.style.display = "none"; // Cacher le badge
            notificationDropdown.innerHTML += `
                <a class="dropdown-item text-center small text-gray-500" href="#">Nessuna notifica</a>
            `;
        }
    } catch (error) {
        console.error("Erreur lors de la récupération des notifications :", error);
    }
}

// Charger les notifications à l'ouverture de la page
document.addEventListener("DOMContentLoaded", fetchNotifications);

// Rafraîchir les notifications toutes les 10 secondes
setInterval(fetchNotifications, 10000);
