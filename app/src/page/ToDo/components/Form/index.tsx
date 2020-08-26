import React, {ChangeEvent, Dispatch, FormEvent, SetStateAction, useState} from 'react';
import {ToDo, ToDoServiceInterface} from "../../../../service/ToDoService";
import {MessageErrorInterface} from "../../../../service/HttpService";
import './styles.css';

interface FormInterface extends ToDoServiceInterface {
    isEdit: boolean,
    setEdit: Dispatch<SetStateAction<boolean>>,
    toDo: ToDo,
    setToDo: Dispatch<SetStateAction<ToDo>>,
    refreshList: Function
}

const Form: React.FC<FormInterface> = (props) => {
    const [message, setMessage] = useState<MessageErrorInterface>({type: 'danger', message: ''});

    const parseDate = (date?: string) => {
        if (date) {
            return date.split(' ')[0];
        }

        return date;
    }

    const newToDo = () => {
        props.setEdit(true);
    }

    const cancelEdit = () => {
        props.setEdit(false);
        props.setToDo({
            id: undefined,
            subject: '',
            description: '',
            date: ''
        });

        props.refreshList();

        setMessage({type: 'danger', message: ''});
    }

    const subjectChange = (input: ChangeEvent<HTMLInputElement>) => {
        const toDo = props.toDo;
        toDo.subject = input.target.value;

        props.setToDo(toDo);
    };

    const descriptionChange = (input: ChangeEvent<HTMLTextAreaElement>) => {
        const toDo = props.toDo;
        toDo.description = input.target.value;

        props.setToDo(toDo);
    };

    const dateChange = (input: ChangeEvent<HTMLInputElement>) => {
        const toDo = props.toDo;
        toDo.date = input.target.value + " 00:00:00";

        props.setToDo(toDo);
    };

    const callbackSaved = (toDo: ToDo) => {
        cancelEdit();
        props.refreshList();
    };

    const submit = (form: FormEvent<HTMLFormElement>) => {
        form.preventDefault();

        props.toDoService.save(props.toDo, setMessage, callbackSaved);
    };

    if (props.isEdit === false) {
        return (
            <button
                type="button"
                className="btn btn-primary w-100"
                onClick={newToDo}
            >
                <i className="fa fa-list"/> Nova tarefa
            </button>
        )
    }

    return (
        <div id="to-do-form">
            <form onSubmit={submit}>
                <div className="form-group">
                    <input
                        type="text"
                        className="form-control"
                        placeholder="Assunto"
                        defaultValue={props.toDo.subject}
                        onChange={subjectChange}
                        required
                    />
                </div>
                <div className="form-group">
                    <textarea
                        className="form-control"
                        placeholder="Descrição"
                        defaultValue={props.toDo.description}
                        onChange={descriptionChange}
                    />
                </div>
                <div className="form-group">
                    <input
                        type="date"
                        className="form-control"
                        placeholder="Assunto"
                        defaultValue={parseDate(props.toDo.date)}
                        onChange={dateChange}
                        required
                    />
                </div>
                {message.message !== '' &&
                <div className={`alert alert-${message.type}`}>{message.message}</div>
                }
                <div className="btn-group w-100">
                    <button type="submit" className="btn btn-success"><i className="fa fa-save"/> Salvar</button>
                    <button
                        type="button"
                        className="btn btn-secondary"
                        onClick={cancelEdit}
                    >
                        <i className="fa fa-close"/> Cancelar
                    </button>
                </div>
            </form>
        </div>
    );
};

export default Form;
