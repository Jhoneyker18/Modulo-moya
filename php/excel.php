<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 70px;
        }
        .cargando {
            display: none;
        }
        .navbar {
            background-color: #563d7c !important;
        }
        .file-input__label {
            display: inline-block;
            cursor: pointer;
            font-weight: bold;
            color: white;
            background-color: #563d7c;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .file-input__label:hover {
            background-color: #6c5a9b;
        }
        .btn-enviar {
            color: white;
            background-color: #563d7c;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-enviar:hover {
            background-color: #6c5a9b;
        }
        .container {
            margin-top: 50px;
        }
        .table-container {
            display: flex;
            justify-content: center;
        }
        .table {
            width: 80%;
            margin: 20px 0;
        }
        .table thead {
            background-color: #563d7c;
            color: white;
        }
    </style>
</head>
<body>
    <div class="cargando">
        <div class="loader-outter"></div>
        <div class="loader-inner"></div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light navbar-dark fixed-top">
        <ul class="navbar-nav mr-auto collapse navbar-collapse"></ul>
        <div class="my-2 my-lg-0">
            <h5 class="navbar-brand">I.U.T.V</h5>
        </div>
    </nav>

    <div class="container">
        <h3 class="text-center">Importación del Excel</h3>
        <hr>

        <div class="row justify-content-center">
            <div class="col-md-7">
                <form action="recibe_excel_validando.php" method="POST" enctype="multipart/form-data">
                    <div class="file-input text-center">
                        <input type="file" name="dataCliente" id="file-input" class="file-input__input" />
                        <label class="file-input__label" for="file-input">
                            <i class="zmdi zmdi-upload zmdi-hc-2x"></i>
                            <span>Elegir Archivo Excel</span>
                        </label>
                    </div>
                    <div class="text-center mt-5">
                        <input type="submit" name="subir" class="btn-enviar" value="Subir Excel" />
                    </div>
                </form>
            </div>
        </div>

        <div class="table-container">
            <?php
            header("Content-Type: text/html;charset=utf-8");
            include('config.php');

            // Conectar a la base de datos
            $con = mysqli_connect("localhost", "root", "", "mod4");
            if (!$con) {
                die("Error de conexión: " . mysqli_connect_error());
            }

            $sqlUsers = "SELECT * FROM users ORDER BY id ASC";
            $queryData = mysqli_query($con, $sqlUsers);
            $total_users = mysqli_num_rows($queryData);
            ?>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Cédula</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Carrera</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Turno</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($data = mysqli_fetch_array($queryData)) { ?>
                        <tr>
                            <th scope="row"><?php echo $i++; ?></th>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['cedula']; ?></td>
                            <td><?php echo $data['password']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td><?php echo $data['carrera']; ?></td>
                            <td><?php echo $data['nombres']; ?></td>
                            <td><?php echo $data['apellidos']; ?></td>
                            <td><?php echo $data['turno']; ?></td>
                            <td><?php echo $data['created_at']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
