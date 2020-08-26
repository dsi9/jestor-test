import React from 'react';
import ReactDOM from 'react-dom';
import App from "./App";
import AppService from "./service/AppService";
import LoginService from "./service/LoginService";
import StorageService from "./service/StorageService";
import HttpService from "./service/HttpService";
import ToDoService from "./service/ToDoService";
import './index.css';

let storage = new StorageService();
let http = new HttpService();
let loginService = new LoginService(storage, http);
let toDoService = new ToDoService(loginService, http);
let appService = new AppService(loginService, toDoService);

ReactDOM.render(
    <React.StrictMode>
        <App appService={appService}/>
    </React.StrictMode>,
    document.getElementById('root')
);
