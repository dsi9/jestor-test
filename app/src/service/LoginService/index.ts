import StorageService from "../StorageService";
import {Dispatch, SetStateAction} from "react";
import HttpService, {MessageErrorInterface} from "../HttpService";
import {AxiosResponse} from "axios";

export interface LoginServiceInterface {
    loginService: LoginService
}

class LoginService {
    public static tokenKey: string = 'tokenBasic';
    private storage: StorageService;
    private http: HttpService;

    constructor(storage: StorageService, http: HttpService) {
        this.storage = storage;
        this.http = http;
    }

    private setToken(token: string) {
        this.storage.set(LoginService.tokenKey, token);
    }

    public token(): string | null {
        return this.storage.get(LoginService.tokenKey);
    }

    public isLogged(): boolean {
        return this.token() !== null;
    }

    public login(
        email: string,
        password: string,
        setMessage: Dispatch<SetStateAction<MessageErrorInterface>>
    ): void {
        setMessage({type: 'info', message: 'Check login...'});

        this.http.post('/login', {email: email, password: password}).then((response: AxiosResponse) => {
            this.setToken(response.data.data.basic);
            setMessage({type: 'success', message: 'Redirect...'});
            window.location.reload();
        }).catch(error => {
            setMessage(HttpService.parseError(error));
        });

    }
}

export default LoginService;
