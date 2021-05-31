import React, {useState} from "react"
import $ from "jquery";
import DrawGrid from "./DrawGrid";

import '../scss/seatGrid.scss'

class RouteOrder extends React.Component{
    constructor(props) {
        super( props );

        let arr = [];


        let item = {
            Route_ID: props.route.Route_ID
        }

        let url = "http://lidabusdiplom.by/controllers/route/getIDPassengerSeatsByRoute.php"

        $.ajax({
            type: 'GET',
            url: url,
            data: {getRouteID: JSON.stringify(item)},
            dataType: 'json',
        }).done(function (response){
            console.log(response);

            for (let i = 0; i < response.length; i++){
                arr[i] = response[i].ID_PassengerSeat
                arr.concat(arr)
                this.setState({
                    seatReserved: arr
                })

              let allSeats = this.state.seat;
                let toRemove = arr;

                this.setState({
                    seatAvailable: allSeats.filter(x => !toRemove.includes(x))
                })

            }
        }.bind(this))

        this.state = {
            seat: [
                "1", "2", "3",
                "4", "5", "6",
                "7", "8", "9",
                "10", "11", "12",
                "13", "14"
            ],
            seatAvailable: [

            ],
            seatReserved: [

            ],
            seatChoosed: [

            ]
        }
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

    testChoosed(){
        console.log(this.state.seatChoosed)
    }

    render() {
        return (
            <>
                <div>
                    <h1>Class Seat Reservation System</h1>
                    <DrawGrid
                        seat = { this.state.seat }
                        available = { this.state.seatAvailable }
                        reserved = { this.state.seatReserved }
                        choosed = {this.state.seatChoosed}
                        onClickData = { this.onClickData.bind(this) }
                    />
                </div>

                <button
                // onClick={this.testChoosed}
                    onClick={this.testChoosed()}
                //     onClick={console.log(this.state)}
                >
                    test
                </button>
           </>
        )
    }
}

export default RouteOrder

