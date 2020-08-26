import React, {useEffect, useState} from 'react';
import Form from "./components/Form";
import List from "./components/List";
import {ToDo, ToDoServiceInterface} from "../../service/ToDoService";
import {MessageErrorInterface} from "../../service/HttpService";
import './styles.css';

const TodoPage: React.FC<ToDoServiceInterface> = ({toDoService}) => {
    const [message, setMessage] = useState<MessageErrorInterface>({type: 'danger', message: ''});
    const [isEdit, setEdit] = useState(false);
    const [toDoList, setToDoList] = useState<ToDo[]>([]);
    const [toDo, setToDo] = useState<ToDo>({
        id: undefined,
        subject: '',
        description: '',
        date: ''
    });

    const refreshList = () => {
        toDoService.getToDoList((data: ToDo[]) => {
            setToDoList(data);
        }, setMessage);
    }

    useEffect(() => {
        refreshList();
    }, []);

    return (
        <div id="to-do">
            <h2 className="text-center">Lista de Tarefas</h2>
            {message.message !== '' &&
            <div className={`alert alert-${message.type}`}>{message.message}</div>
            }
            <Form
                toDoService={toDoService}
                isEdit={isEdit}
                setEdit={setEdit}
                toDo={toDo}
                setToDo={setToDo}
                refreshList={refreshList}
            />
            <List
                toDoService={toDoService}
                refreshList={refreshList}
                setToDo={setToDo}
                setEdit={setEdit}
                toDoList={toDoList}
                setMessage={setMessage}
            />
        </div>
    );
};

export default TodoPage;
