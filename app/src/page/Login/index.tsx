import React, {FormEvent, useState} from 'react';
import {LoginServiceInterface} from "../../service/LoginService";
import {MessageErrorInterface} from "../../service/HttpService";
import './styles.css';

const LoginPage: React.FC<LoginServiceInterface> = ({loginService}) => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [message, setMessage] = useState<MessageErrorInterface>({type: 'danger', message: ''});

    const onSubmit = (form: FormEvent) => {
        form.preventDefault();

        loginService.login(email, password, setMessage);
    };

    return (
        <div id="login">
            <form className="form-signin" onSubmit={onSubmit}>
                <h1 className="h3 mb-3 font-weight-normal text-center">Lista de tarefas</h1>
                <label htmlFor="inputEmail" className="sr-only">Email address</label>
                <input
                    type="email"
                    className="form-control"
                    placeholder="Email"
                    required
                    autoFocus
                    onChange={(event) => setEmail(event.target.value)}
                />
                <label htmlFor="inputPassword" className="sr-only">Senha</label>
                <input
                    type="password"
                    className="form-control"
                    placeholder="Senha"
                    required
                    onChange={(event) => setPassword(event.target.value)}
                />
                {message.message !== '' &&
                <div className={`alert alert-${message.type}`}>
                    {message.message}
                </div>
                }
                <button className="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            </form>
        </div>
    );
}

export default LoginPage;
