const { DataTypes } = require('sequelize');
const sequelize = require('./index').sequelize;

const Proyecto = sequelize.define('Proyecto', {
    titulo: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    descripcion: {
        type: DataTypes.TEXT,
        allowNull: true,
    },
    completada: {
        type: DataTypes.BOOLEAN,
        defaultValue: false,
    },
    fecha_creacion: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
    },
    fecha_vencimiento: {
        type: DataTypes.DATE,
        allowNull: true,
    },
    prioridad: {
        type: DataTypes.ENUM('baja', 'media', 'alta'),
        defaultValue: 'media',
    },
    asignado_a: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    categoria: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    costo_proyecto: {
        type: DataTypes.FLOAT,
        allowNull: false,
    },
    pagado: {
        type: DataTypes.BOOLEAN,
        defaultValue: false,
    },
});

module.exports = Proyecto;
