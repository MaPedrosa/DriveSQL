<?php
// ... (código existente)

if ($stmt->execute()) {
    // Registro bem-sucedido
    
    // Lógica adicional (enviar e-mail, etc.)
    // ...

    echo "<script>alert('Registro bem-sucedido!'); location.href='login.php';</script>";
} else {
    // ... (código existente)
}
