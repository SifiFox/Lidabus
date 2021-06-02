import React from 'react'
import '../scss/seatGrid.scss'

function SeatsGrid(props){



    // console.log(props.seats)
    function onClickSeat(row) {
        // props.onClickData(row)
        // console.log(props.onClickData(props.seats.seat))
        console.log(props.seats)
    }

    return(
        <div className="container">
            {/*{*/}
            {/*    props.seat.map(row =>*/}
            {/*    console.log(row)*/}
            {/*    )*/}
            {/*}*/}
            <h2></h2>
            <table className="grid">
                <tbody>
                <tr>
                    {/*{*/}
                    {/*    console.log(props.seats)*/}
                    {/*}*/}
                    {props.seats.map( row =>
                        <td
                            className={props.reserved.indexOf(row) > -1? 'reserved': 'available'}
                            key={row} onClick = {e => onClickSeat(row)}>{row} </td>) }

                </tr>
                </tbody>
            </table>

        </div>
    )
}

export default SeatsGrid