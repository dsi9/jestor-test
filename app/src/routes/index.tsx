import React from "react";
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Redirect
} from "react-router-dom";
import LoginPage from "../page/Login";
import {AppServiceInterface} from "../service/AppService";
import TodoPage from "../page/ToDo";

const MainRoutes: React.FC<AppServiceInterface> = ({appService}) => {
    return (
        <Router>
            <Switch>
                <Route key="login" path="/app" exact={true}>
                    {appService.loginService.isLogged() ? <Redirect to="/app/to-do"/> :
                        <LoginPage loginService={appService.loginService}/>}
                </Route>
                <Route key="to-do" path="/app/to-do" exact={true}>
                    {appService.loginService.isLogged() ? <TodoPage toDoService={appService.toDoService} /> : <Redirect to="/app"/>}
                </Route>
                <Route key="not-found" path="*">
                    <h1>Not Found</h1>
                </Route>
            </Switch>
        </Router>
    );
}

export default MainRoutes;
