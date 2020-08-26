import React, {Dispatch, SetStateAction} from 'react';
import ToDoService, {ToDo, ToDoServiceInterface} from "../../../../service/ToDoService";
import {MessageErrorInterface} from "../../../../service/HttpService";
import './styles.css';

interface FormInterface extends ToDoServiceInterface {
    setEdit: Dispatch<SetStateAction<boolean>>,
    setToDo: Dispatch<SetStateAction<ToDo>>,
    toDoList: ToDo[],
    refreshList: Function,
    toDoService: ToDoService,
    setMessage: Dispatch<SetStateAction<MessageErrorInterface>>
}

const List: React.FC<FormInterface> = (props) => {

    const parseDate = (date: string) => {
        return date.split(' ')[0];
    }

    const editItem = (toDo: ToDo) => {
        props.setToDo(toDo);
        props.setEdit(true);
    }

    const deleteItem = (toDo: ToDo) => {
        props.toDoService.delete(toDo, () => {
            props.refreshList();
        }, props.setMessage)
    }

    return (
        <div id="to-do-list" className="mt-4">
            <div className="list-group pb-2 pt-0">
                {props.toDoList.map((toDo: ToDo) =>
                    <div key={toDo.id}
                         className="list-group-item list-group-item-action flex-column align-items-start mt-1">
                        <div className="d-flex w-100 justify-content-between">
                            <h5 className="mb-1">{toDo.subject}</h5>
                            <small>{parseDate(toDo.date)}</small>
                        </div>
                        <p className="mb-1">{toDo.description}</p>
                        <div className="btn-group btn-group-sm w-100">
                            <button
                                onClick={() => editItem(toDo)}
                                type="button"
                                className="btn btn-primary"
                            >
                                <i className="fa fa-edit"/>
                            </button>
                            <button
                                onClick={() => deleteItem(toDo)}
                                type="button"
                                className="btn btn-danger"
                            >
                                <i className="fa fa-trash"/>
                            </button>
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
};

export default List;
