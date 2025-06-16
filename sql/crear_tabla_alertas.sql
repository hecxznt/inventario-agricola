CREATE TABLE IF NOT EXISTS alertas_enviadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    tipo_alerta ENUM('stock', 'caducidad') NOT NULL,
    fecha_alerta DATETIME NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
); 