import axios, {AxiosInstance, AxiosRequestConfig, AxiosResponse} from 'axios';

export interface MessageErrorInterface {
    type: string,
    message: string
}

class HttpService {
    private host: string = 'http://localhost:8080/api';
    private http: AxiosInstance;

    constructor() {
        this.http = axios.create({
            baseURL: this.host
        });
    }

    async post(path: string, data: object, basic?: string | null): Promise<AxiosResponse> {
        return await this.http.post(path, data, HttpService.createConfig(basic));
    }

    async put(path: string, data: object, basic?: string | null): Promise<AxiosResponse> {
        return await this.http.put(path, data, HttpService.createConfig(basic));
    }

    async get(path: string, basic?: string | null): Promise<AxiosResponse> {
        return await this.http.get(path, HttpService.createConfig(basic));
    }

    async delete(path: string, basic?: string | null): Promise<AxiosResponse> {
        return await this.http.delete(path, HttpService.createConfig(basic));
    }

    public static createConfig(basic?: string | null): AxiosRequestConfig {
        let config = {};

        if (basic) {
            config = {
                headers: {
                    'Authorization': `Basic ${basic}`
                }
            };
        }

        return config;
    }

    public static parseError(error: any): MessageErrorInterface {
        let messageError = 'Request Error';

        if (error.response) {
            messageError = error.response.data.message;
        }

        return {type: 'danger', message: messageError};
    }
}

export default HttpService;