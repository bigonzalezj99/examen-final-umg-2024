// const express = require('express');
// const app = express();
// const proyectoRoutes = require('./routes/proyecto');
// require('dotenv').config();
// const sequelize = require('./config/database');

// app.use(express.json());
// app.use('/api/proyectos', proyectoRoutes);

// sequelize.sync()
//     .then(() => console.log('Database connected and synced'))
//     .catch(err => console.error('Error syncing database:', err));

// module.exports = app;


const { Sequelize } = require('sequelize');
const dbConfig = require('/config/database.js');

const sequelize = new Sequelize(dbConfig.DB, dbConfig.USER, dbConfig.PASSWORD, {
    host: dbConfig.HOST,
    dialect: dbConfig.dialect,
    dialectOptions: dbConfig.dialectOptions,
});

const db = {};
db.Sequelize = Sequelize;
db.sequelize = sequelize;

module.exports = db;

