import React, {useState} from "react"
import $ from "jquery";
import DrawGrid from "./DrawGrid";
import '../scss/seatGrid.scss'

class RouteOrder extends React.Component{
    constructor(props) {
        super( props );

        console.log(props)

        localStorage.setItem('Route_ID', props.route.Route_ID)

        this.handleMapLida = this.handleMapLida.bind(this);
        this.handleMapMinsk = this.handleMapMinsk.bind(this);
        this.handleChangeFrom = this.handleChangeFrom.bind(this);
        this.handleChangeTo = this.handleChangeTo.bind(this);
        this.handlePromocode = this.handlePromocode.bind(this);

        var arr = [];
        let item = {
            Route_ID: props.route.Route_ID
        }
        var test = [ "1", "2", "3",
            "4", "5", "6",
            "7", "8", "9",
            "10", "11", "12",
            "13", "14", "15", "16"]

        props.route.SeatsNumber == 14
            ?
            test = [
                "1", "2", "3",
                "4", "5", "6",
                "7", "8", "9",
                "10", "11", "12",
                "13", "14"
            ]
            : (props.route.SeatsNumber == 15 ?   test = [
                "1", "2", "3",
                "4", "5", "6",
                "7", "8", "9",
                "10", "11", "12",
                "13", "14", "15"
            ] : test = [
                "1", "2", "3",
                "4", "5", "6",
                "7", "8", "9",
                "10", "11", "12",
                "13", "14", "15", "16"
            ])


        let init = false;

        this.state = {
            fromState: '',
            toState: '',
            promocode: '',

            mapLidaShowed: init,
            mapMinskShowed: init,

            seat: test,
            seatAvailable: [
                "1", "2", "3",
                "4", "5", "6",
                "7", "8", "9",
                "10", "11", "12",
                "13", "14"
            ],
            seatReserved: [

            ],
            seatChoosed: [

            ]
        }

        let url = "http://lidabusdiplom.by/controllers/route/getIDPassengerSeatsByRoute.php";

        $.ajax({
            type: 'GET',
            url: url,
            data: {getRouteID: JSON.stringify(item)},
            dataType: 'json',
        }).done(function (response){

            for (let i = 0; i < response.length; i++){

                arr[i] = response[i].ID_PassengerSeat
                arr.concat(arr)


                let allSeats = this.state.seat;
                let toRemove = arr;

                arr.length == 0 ?
                    this.setState({
                        seatReserved: arr,
                        seatAvailable: allSeats.filter(x => !toRemove.includes(x))
                    })
                    : this.setState({
                        seatReserved: arr,
                        seatAvailable: allSeats
                    })
            }
        }.bind(this))
    }

    handleChangeFrom(event) {
        this.setState({fromState: event.target.value});
    }

    handleChangeTo(event) {
        this.setState({toState: event.target.value});
    }
    handlePromocode(event){
        this.setState({promocode: event.target.value});
    }


    onClickData(seat) {
        if(this.state.seatAvailable.indexOf(seat) > -1  && this.state.seatChoosed.length <= 4) {
            this.setState({
                seatChoosed: this.state.seatChoosed.concat(seat),
                seatAvailable: this.state.seatAvailable.filter(res => res != seat)
            })
        } else {
            this.setState({
                seatAvailable: this.state.seatAvailable.concat(seat),
                seatChoosed: this.state.seatChoosed.filter(res => res != seat)
            })
        }
    }

    handleMapLida(){
            this.setState(state => ({
                mapLidaShowed: !state.mapLidaShowed
            }));
    }

    handleMapMinsk(){
        this.setState(state => ({
            mapMinskShowed: !state.mapMinskShowed
        }));
    }

    render() {
       function testChoosed(){
           let testStr

           let item = {
               ID_User: localStorage.getItem('ID'),
               ID_PassengerSeat: testStr,
               PassengerCount: '',
               ID_Route: localStorage.getItem('Route_ID'),
               Promocode: localStorage.getItem('Promocode'),
               ID_Auto: 2,
               StartPoint: localStorage.getItem('StartPoint'),
               EndPoint: localStorage.getItem('EndPoint')
           }
           let testArr = [];
           var choosedSeats = document.getElementsByClassName("choosed");
           for (var i = 0; i < choosedSeats.length; i++) {
               testArr.push(choosedSeats[i].innerText);
           }

           testArr = testArr + ""
           testArr = testArr.replace(/\s+/g,'');
           testStr = testArr.split(',')
           item.ID_PassengerSeat = testStr
           item.PassengerCount = testStr.length
           console.log(item);


          if(!localStorage.getItem("Name")) {
              alert('вы не авторизированы');
              document.location.assign('/');
          }else{
           let url = "http://lidabusdiplom.by/controllers/order/setOrder.php";
           $.ajax({
               type: 'POST',
               url: url,
               data: {setOrder: JSON.stringify(item)},
               dataType: 'json',

               complete: function (response){
                   alert(response.responseText);
                   document.location.assign('/profile');
               }
           })
          }
       }

        return (
            <>
                <div>
                    <h1>Выберите места</h1>
                    <DrawGrid
                        seat = { this.state.seat }
                        available = { this.state.seatAvailable }
                        reserved = { this.state.seatReserved }
                        choosed = {this.state.seatChoosed}
                        lidaShowed = {this.state.mapLidaShowed}
                        onClickData = { this.onClickData.bind(this) }
                    />

                    {
                        this.props.route.Destination == 'Лида' ?
                        <>
                            <p>откуда</p>
                            <select value={this.state.fromState} onChange={this.handleChangeFrom}>
                                <option value="Шейбаки" defaultValue={'Шейбаки'}>Шейбаки</option>
                                <option value="Ресторан Легенда">Ресторан Легенда</option>
                                <option value="Гипермаркет Евроопт">Гипермаркет Евроопт</option>
                                <option value="Южный">Южный</option>
                                <option value="Вокзал">Вокзал</option>
                            </select>
                            <div className="clickable"
                            onClick={this.handleMapLida}
                            >
                                Показать на карте
                            </div>
                            <iframe className={this.state.mapLidaShowed ? "visible" : "hidden"}
                                    src="https://yandex.ru/map-widget/v1/?um=constructor%3A198ebadabf978b0ad79aac6514e24d8af04f672aa829ceeb27ab6e5da7f5cd1e&amp;source=constructor"
                                    width="320" height="240" frameBorder="0"></iframe>


                            <p>куда</p>
                            <select value={this.state.toState} onChange={this.handleChangeTo}>
                                <option value="Толстого 32">Толстого 32</option>
                                <option value="Пушкинская">Пушкинская</option>
                                <option value="Спортивная">Спортивная</option>
                                <option value="Каменная горка">Каменная горка</option>
                            </select>
                            <div className="clickable"
                                 onClick={this.handleMapMinsk}
                            >
                                Показать на карте
                            </div>
                            <iframe className={this.state.mapMinskShowed ? "visible" : "hidden"}
                                    src="https://yandex.ru/map-widget/v1/?um=constructor%3A8afe147cbd720fdca1497002ab85b1d4c2ae8e46f546da07c589daef682e1ddf&amp;source=constructor"
                                    width="320" height="240" frameBorder="0"></iframe>


                            <p>Промокод</p>
                            <input type="text" placeholder="промокод" onChange={this.handlePromocode} />
                            {
                                localStorage.setItem('Promocode', this.state.promocode)
                            }
                        </>
                        :
                        <>
                            <p>откуда</p>
                            <select value={this.state.fromState} onChange={this.handleChangeFrom}>
                                <option value="Толстого 32" >Толстого 32</option>
                                <option value="Пушкинская">Пушкинская</option>
                                <option value="Спортивная">Спортивная</option>
                                <option value="Каменная горка">Каменная горка</option>
                            </select>


                            <p>куда</p>
                            <select value={this.state.toState} onChange={this.handleChangeTo}>
                                <option value="Шейбаки">Шейбаки</option>
                                <option value="Ресторан Легенда">Ресторан Легенда</option>
                                <option value="Гипермаркет Евроопт">Гипермаркет Евроопт</option>
                                <option value="Южный">Южный</option>
                                <option value="Вокзал">Вокзал</option>
                            </select>
                            <iframe
                                src="https://yandex.ru/map-widget/v1/?um=constructor%3A198ebadabf978b0ad79aac6514e24d8af04f672aa829ceeb27ab6e5da7f5cd1e&amp;source=constructor"
                                width="320" height="240" frameBorder="0"></iframe>
                        </>
                    }

                    {
                        localStorage.setItem('StartPoint', this.state.fromState)
                    }
                    {
                        localStorage.setItem('EndPoint', this.state.toState)
                    }
                </div>

                
                <button
                    onClick={testChoosed}
                >
                    test
                </button>
           </>
        )
    }
}

export default RouteOrder

