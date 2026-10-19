# T-APP (Teatro App) 🎭

**T-APP** è un'applicazione web logica *three-tier* progettata e sviluppata per la **gestione completa delle vendite dei biglietti, degli abbonamenti e del controllo degli accessi** per il Teatro Comunale di Bologna. 

Il sistema separa nettamente l'esperienza dell'utente finale (lato cliente) dagli strumenti di gestione e analisi aziendale (lato amministratore, suddiviso in tre livelli di permessi).

---

## 🚀 Architettura e Tecnologie

L'applicazione è strutturata su un'architettura **Three-Tier** basata sul pattern **MVP (Model-View-Presenter) con RESTful API CRUD** per la comunicazione client-server:

*   **Frontend (Livello Presentazione):** HTML5, CSS3, JavaScript (Vanilla) e **Bootstrap** per garantire un web design completamente *responsive* (PC, Tablet, Smartphone).
*   **Backend (Livello Applicazione):** **PHP** per la logica di business e la gestione delle API.
*   **Database (Livello Dati):** **MySQL** relazionale per la persistenza dei dati e la sicurezza delle informazioni.
*   **Ambiente di Sviluppo/Hosting Locale:** WampServer (Apache, MySQL, PHP) su Windows 11.

---

## 🛠️ Funzionalità Principali

### 👤 Lato Cliente
*   **Autenticazione:** Registrazione sicura e login utente con password criptate.
*   **Catalogo Spettacoli:** Consultazione degli eventi disponibili con filtri di ricerca avanzati.
*   **Booking e Posti:** Scelta interattiva del posto in sala associato allo spettacolo.
*   **Sistemi di Pagamento:** Doppia opzione (gateway di pagamento online o transazione fisica presso i Punti Vendita).
*   **Ricevuta Digitale:** Generazione automatica e invio tramite e-mail del biglietto elettronico.
*   **Self-Management:** Modifica o cancellazione autonoma di biglietti e abbonamenti con gestione dei rimborsi.

### 🛡️ Lato Amministratore (Livelli di Accesso)
Il pannello di controllo prevede tre ruoli distinti con permessi specifici:
1.  **Admin Generale:** Gestione completa degli utenti, abilitazione dei Punti Vendita, inserimento/CRUD degli spettacoli e monitoraggio della piattaforma.
2.  **Punti di Vendita:** Emissione fisica, modifica e cancellazione di biglietti e abbonamenti sul posto.
3.  **Controllori:** Validazione dei ticket all'ingresso della struttura con tracciamento in tempo reale dell'ora esatta di accesso.

📊 **Business Intelligence:** Il sistema integra un'interfaccia grafica per l'analisi dei dati, che mostra statistiche in tempo reale sull'andamento delle vendite e l'affluenza del pubblico.

---

## 🔒 Sicurezza e Requisiti Non Funzionali
*   **Protezione dei dati:** Cifratura delle password nel database.
*   **Incolumità del Database:** Meccanismi di prevenzione nativi contro attacchi di tipo *SQL Injection*.
*   **Flessibilità:** Interfaccia utente multidevice grazie a un layout fluido.

---

## 💻 Configurazione in Locale

Per testare o avviare il progetto sul proprio computer:

1.  **Prerequisiti:** Installare un ambiente LAMP/WAMP (consigliato **WampServer**).
2.  **Clonare la repository:**
    ```bash
    git clone https://github.com
    ```
3.  **Database:** Importare il file del database MySQL (es. `teatro.sql`) all'interno del proprio gestore (phpMyAdmin).
4.  **Spostare i file:** Posizionare la cartella del progetto nella directory principale del server locale (es. `C:\wamp64\www\`).
5.  **Avvio:** Aprire il browser e navigare su `http://localhost/nome-cartella`.

---

## 🎓 Note di Sviluppo
Questo software è stato realizzato come progetto per la **Tesi di Laurea Triennale in Informatica** presso l'**Università di Parma** (Anno Accademico 2024–2025).
*   **Candidato:** Jeremie Fwapa KORANGI
*   **Relatore:** Prof. Flavio BERTINI
