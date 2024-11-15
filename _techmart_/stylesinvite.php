<?php
echo '
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding-top: 20px; /* Зробимо трохи більше простору зверху */
        }

        h1 {
            color: #4CAF50;
            margin-top: 0;
        }

        h3 {
            color: #555;
        }

        form {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            text-align: left;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="date"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f8f9fa;
            color: #495057;
        }

        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form input[type="date"]:focus {
            background-color: #e9ecef;
            border-color: #4CAF50;
            outline: none;
        }

        form input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            padding: 10px;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: bold;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        ul {
            list-style: none;
            padding: 0;
            text-align: center;
            margin: 20px 0;
            width: 100%;
        }

        li {
            display: inline;
            margin: 0 10px;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            border: 1px solid #4CAF50;
            padding: 8px 12px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: #4CAF50;
            color: #fff;
        }
    </style>
';
?>
