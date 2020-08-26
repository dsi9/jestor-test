import {Dispatch, SetStateAction} from "react";
import HttpService, {MessageErrorInterface} from "../HttpService";
import LoginService from "../LoginService";
import {AxiosResponse} from "axios";

export interface ToDoServiceInterface {
    toDoService: ToDoService
}

export interface ToDo {
    id?: number,
    subject: string,
    description: string,
    date: string
}

class ToDoService {
    private loginService: LoginService;
    private http: HttpService;

    constructor(loginService: LoginService, http: HttpService) {
        this.loginService = loginService;
        this.http = http;
    }

    public save(
        toDo: ToDo,
        setMessage: Dispatch<SetStateAction<MessageErrorInterface>>,
        callbackSaved: Function
    ): void {
        let path = '/todo-list';
        let response;

        if (toDo.id) {
            path += '/' + toDo.id;

            toDo.id = undefined;
            response = this.http.put(path, toDo, this.loginService.token());
        } else {
            response = this.http.post(path, toDo, this.loginService.token());
        }

        response.then((response: AxiosResponse) => {

            callbackSaved(response.data);

        }).catch(error => {
            setMessage(HttpService.parseError(error));
        });
    }

    public getToDoList(callbackGet: Function, setMessage: Dispatch<SetStateAction<MessageErrorInterface>>): void {
        this.http.get('/todo-list', this.loginService.token()).then((response: AxiosResponse) => {

            callbackGet(response.data.data);

        }).catch(error => {
            setMessage(HttpService.parseError(error));
        });
    }

    public delete(toDo: ToDo, callbackGet: Function, setMessage: Dispatch<SetStateAction<MessageErrorInterface>>): void {
        this.http.delete('/todo-list/' + toDo.id, this.loginService.token()).then((response: AxiosResponse) => {

            callbackGet(response.data.data);

        }).catch(error => {
            setMessage(HttpService.parseError(error));
        });
    }
}

export default ToDoService;