import React, {useState} from 'react'
import $ from "jquery";


function AssignPromocode(){


    const [user, setUser] = useState()
    const [promocode, setPromocode] = useState()

    function userHeandler(e){
        setUser(e.target.value)
    }

    function promocodeHeandler(e){
        setPromocode(e.target.value)
    }


    let item = {
        ID_User: user,
        ID_Promocode: promocode
    }

    function createPromocodes(e){
        e.preventDefault()
        console.log(item)
        let url = "http://lidabusdiplom.by/controllers/admin/users/assignPromocodeToUser.php"
        $.ajax({
            xhrFields: {cors: false},
            mode: "no-cors",
            type: "POST",
            url:  url,
            data: {assignPromocodeToUser: JSON.stringify(item)},
            dataType: "json",
            complete: function (response){
                console.log(response);
            }
        }).done(function (data) {
            console.log(data);
        });
    }


    return(
        <>
            <p>Создать промокоды</p>

            <form className="modal--input" method="post">
                <div className="input--wrapper">
                    <input  type="text" className="form--input" placeholder="ID пользователя"
                            onChange={e => userHeandler(e)}   />
                </div>

                <div className="input--wrapper">
                    <input type="text" className="form--input" placeholder="ID промокода"
                           onChange={e => promocodeHeandler(e)}  />
                </div>


                <div className="reg--navigate">
                    <button className='reg--button'
                            onClick={event => createPromocodes(event)}
                    >
                        Создать промокоды
                    </button>

                </div>
            </form>

        </>
    )
}

export default AssignPromocode