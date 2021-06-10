import React, {useState} from 'react'
import $ from "jquery";

function CreatePromocodes(){

    const [countPromo, setCountPromo] = useState()

    const [sale, setSale] = useState()


    function countPromocodesHeandler(e){
        setCountPromo(e.target.value)
    }

    function saleHeandler(e){
        setSale(e.target.value)
    }


    let item = {
        Sale: sale,
        Count: countPromo
    }

    function createPromocodes(e){
        e.preventDefault()
        console.log(item)
        let url = "http://lidabusdiplom.by/controllers/admin/users/createPromocode.php"
        $.ajax({
            xhrFields: {cors: false},
            mode: "no-cors",
            type: "POST",
            url:  url,
            data: {createPromocode: JSON.stringify(item)},
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
                    <input  type="text" className="form--input" placeholder="Количество промокодов"
                           onChange={e => countPromocodesHeandler(e)}   />
                </div>

                <div className="input--wrapper">
                    <input type="text" className="form--input" placeholder="Скидка"
                           onChange={e => saleHeandler(e)}  />
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

export default CreatePromocodes