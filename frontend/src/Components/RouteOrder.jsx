import React, {useState} from "react"
import $ from "jquery";
import DrawGrid from "./DrawGrid";
import '../scss/seatGrid.scss'

class RouteOrder extends React.Component{
    constructor(props) {
        super( props );

        console.log(props)

        localStorage.setItem('Route_ID', props.route.Route_ID)

        this.handleChangeFrom = this.handleChangeFrom.bind(this);
        this.handleChangeTo = this.handleChangeTo.bind(this);

        var arr = [];
        let item = {
            Route_ID: props.route.Route_ID
        }

        this.state = {
            fromState: '',
            toState: '',

            seat: [
                "1", "2", "3",
                "4", "5", "6",
                "7", "8", "9",
                "10", "11", "12",
                "13", "14"
            ],
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

        // props.route.Destination == "Лида"
        //     ?   this.setState({
        //         fromState: 'Вокзал',
        //         toState: 'Толстова 32'
        //     })
        //     :  this.setState({
        //         fromState: 'Толстова 32',
        //         toState: 'Вокзал'
        //     })


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




    render() {
       function testChoosed(){
           let testStr

           let item = {
               ID_User: localStorage.getItem('ID'),
               ID_PassengerSeat: testStr,
               PassengerCount: '',
               ID_Route: localStorage.getItem('Route_ID'),
               Promocode: '',
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

        return (
            <>
                <div>
                    <h1>Выберите места</h1>
                    <DrawGrid
                        seat = { this.state.seat }
                        available = { this.state.seatAvailable }
                        reserved = { this.state.seatReserved }
                        choosed = {this.state.seatChoosed}
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

                            <p>куда</p>
                            <select value={this.state.toState} onChange={this.handleChangeTo}>
                                <option value="Толстого 32">Толстого 32</option>
                                <option value="Пушкинская">Пушкинская</option>
                                <option value="Спортивная">Спортивная</option>
                                <option value="Каменная горка">Каменная горка</option>
                            </select>

                            <p>Промокод</p>
                            <input type="text" placeholder="промокод" />
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

