import React from 'react'
import '../scss/advantages.scss'

function Advantages(){

    return(
        <div className="advantages--wrap">
            <h3>почему мы</h3>

            <div className="advantages--content--wrap">
                <div className="advantages--column">
                    <div className="advantages--item">
                        <p>лучший оффициальный перевозчик в Лиде</p>
                    </div>
                    <div className="advantages--item">
                        <p>профессиональные водители со стажем более 5 лет</p>
                    </div>
                    <div className="advantages--item">
                        <p>круглосуточная техподдержка</p>
                    </div>
                </div>

                <div className="advantages--column">
                    <div className="advantages--item">
                        <p>наши пассажиры застрахованы</p>
                    </div>
                    <div className="advantages--item">
                        <p>отправление каждые 30 минут</p>
                    </div>
                    <div className="advantages--item">
                        <p>современные, комфортные автомобили с кондиционером и Wi-Fi</p>
                    </div>
                </div>


            </div>

        </div>

    )
}

export default Advantages

