<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Validación solo números</title>
</head>
<body>
  <h2>Ejemplo con pattern (solo números)</h2>

  <form>
    <label for="txtNumber">Ingrese solo números:</label><br>
    <input type="text" id="txtNumber" name="txtNumber"
           required
           placeholder="Solo números"
           pattern="^[0-9]{10,255}$"
           title="Debe contener solo números (mínimo 10, máximo 255)">
    <br><br>

    <button type="submit">Enviar</button>
  </form>
</body>
</html>
