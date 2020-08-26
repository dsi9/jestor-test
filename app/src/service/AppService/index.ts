import LoginService from "../LoginService";
import ToDoService from "../ToDoService";

export interface AppServiceInterface {
    appService: AppService
}

class AppService {
    public loginService: LoginService;
    public toDoService: ToDoService;

    constructor(loginService: LoginService, toDoService: ToDoService) {
        this.loginService = loginService;
        this.toDoService = toDoService;
    }
}

export default AppService;