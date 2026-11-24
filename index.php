<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['sistema'])) {
    $stmt = $pdo->prepare("INSERT INTO bitacora_guardia (sistema, evento, severidad) VALUES (:sistema, :evento, :severidad)");
    $stmt->execute([
        'sistema'   => $_POST['sistema'],
        'evento'    => $_POST['evento'],
        'severidad' => $_POST['severidad']
    ]);
    header("Location: index.php");
    exit;
}

$registros = $pdo->query("SELECT * FROM bitacora_guardia ORDER BY fecha_registro DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora TI - Rol de Guardia</title>
    <link href="https://jsdelivr.net" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4 text-primary">Bitácora de Continuidad Operativa y Guardia TI</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Plataforma / Sistema</label>
                    <input type="text" name="sistema" class="form-control" placeholder="Ej: Portal Web / DNS" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Severidad</label>
                    <select name="severidad" class="form-select">
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Descripción del Evento o Parche</label>
                    <input type="text" name="evento" class="form-control" placeholder="Ej: Actualización SSL y parches SO" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrar en Bitácora</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive bg-white rounded shadow-sm p-3">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Sistema</th>
                    <th>Severidad</th>
                    <th>Evento / Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['fecha_registro']) ?></td>
                    <td><strong><?= htmlspecialchars($r['sistema']) ?></strong></td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($r['severidad']) ?></span></td>
                    <td><?= htmlspecialchars($r['evento']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>