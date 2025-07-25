<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Em Construção - Sistema de Agendamentos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            text-align: center;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        
        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
            font-weight: 300;
        }
        
        .icon {
            font-size: 5rem;
            margin-bottom: 2rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .progress-bar {
            width: 100%;
            height: 10px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            margin-bottom: 2rem;
            overflow: hidden;
            position: relative;
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 30%;
            background-color: #fff;
            border-radius: 5px;
            animation: progress 3s infinite;
        }
        
        @keyframes progress {
            0% {
                width: 0%;
                left: 0;
            }
            50% {
                width: 30%;
                left: 70%;
            }
            100% {
                width: 0%;
                left: 100%;
            }
        }
        
        .contact {
            margin-top: 2rem;
            font-size: 0.9rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🚧</div>
        <h1>Site em Construção</h1>
        <div class="progress-bar"></div>
        <p>Estamos trabalhando duro para trazer um novo sistema de agendamentos que vai revolucionar a forma como você gerencia seu tempo.</p>
        <p>Volte em breve para conferir nosso lançamento!</p>
        <div class="contact">
            <p>Para mais informações, entre em contato: contato@agendamentos.com</p>
        </div>
    </div>
</body>
</html>