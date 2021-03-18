import React from 'react'
import '../scss/contacts.scss'

    const Contacts = (props) =>{
    return(
        <div className="contacts--wrapper">
                <div className="form--wrapper">
                        <h3>Связаться с нами</h3>
                    <form action="">
                        <input type="text" className="help--input" placeholder="Ваше имя"/>

                        <input type="text" className="help--input" placeholder="e-mail"/>

                        <input type="text" className="help--input" placeholder="Сообщение"/>
                    </form>
                </div>
        </div>
    )
}

export default Contacts