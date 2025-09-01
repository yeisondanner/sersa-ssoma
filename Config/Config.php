<?php

//Variable constante de la URL del proyecto
const BASE_URL = "http://localhost/sis-roles";
//Ruta de almacenamiento de archivos
const RUTA_ARCHIVOS = "./Storage/";
//Nombre del sistema
const NOMBRE_SISTEMA = "Sistema de Roles";
//Nombre de la compania
const NOMBRE_COMPANIA = "CYD TECH";
//Zona horaria
date_default_timezone_set('America/Lima');

//Datos de conexión a Base de Datos
const DB_HOST = "localhost";
const DB_NAME = "bd_users";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_CHARSET = "utf8";

//Deliminadores decimal y millar Ej. 24,1989.00
const SPD = ".";
const SPM = ",";

//Simbolo de moneda
const SMONEY = "S/.";

//Datos envio de correo
const MAIL_HOST = "mail.shaday-pe.com";
const MAIL_PORT = 465;
const MAIL_USER = "pureba@shaday-pe.com";
const MAIL_PASSWORD = "X5XFy46Qp?g_";
const MAIL_ENCRYPTION = "ssl";
const MAIL_FROM = "info@shaday-pe.com";//nombre del remitente
const MAIL_REMITENTE = "Sistema de Roles";
//Variables de encriptacion
const METHOD = "AES-256-CBC";
const SECRET_KEY = "SystemOfPredios2025";
const SECRET_IV = "@2025BajoNaranjillo";
//nombre de la sesion
const SESSION_NAME = "Sistemade-gestion-de-Roles";
//Generador de perfiles mediante nombre
const GENERAR_PERFIL = "https://ui-avatars.com/api/?name=";
//Variables de la API api.apis.net.pe
const API_KEY = "apis-token-13092.cwy578uEtUFPCWYnJN5uI83i6WuTRvVM";
const API_URL_RENIEC = "https://api.apis.net.pe/v2/reniec/dni?numero=";
const API_URL_RUC = "https://api.apis.net.pe/v2/sunat/ruc?numero=";