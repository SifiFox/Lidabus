import React from 'react'

class DrawGrid extends React.Component {
    render() {
        return (
            <div className="container">
                <h2></h2>
                <table className="grid">
                    <tbody>
                    <tr>
                        { this.props.seat.map( row =>
                            <td className={
                                this.props.reserved.indexOf(row) > -1

                                ? 'reserved'

                                : (this.props.choosed.indexOf(row) > -1 ? 'choosed' : 'avaliable')
                            }

                                key={row} onClick = {e => this.onClickSeat(row)}>{row} </td>) }
                    </tr>
                    </tbody>
                </table>
            </div>
        )
    }

    onClickSeat(seat) {
        this.props.onClickData(seat);
    }
}
export default DrawGrid