<style>
        body {
            margin: 0;
            height: 100vh;
            background-image: url('img/teatro.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7); /* nero con opacità 50% */
            z-index: 1;
        }

        .ftco-section {
            position: relative;
            z-index: 2; /* per portare il contenuto sopra l'overlay */
            color: white; /* testo in bianco */
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

    </style>