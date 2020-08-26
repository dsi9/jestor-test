import React from 'react';
import MainRoutes from "./routes";
import {AppServiceInterface} from "./service/AppService";

const App: React.FC<AppServiceInterface> = ({appService}) => {
    return (
        <React.StrictMode>
            <MainRoutes appService={appService}/>
        </React.StrictMode>
    );
}

export default App;
