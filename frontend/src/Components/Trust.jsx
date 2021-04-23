import React from 'react'

import '../scss/trust.scss'



    function Trust (){
       return(
           <div className="trust--wrap">
               <h2 className="section--description">
                   нам доверяют
               </h2>

               <div className="trust--info--wrap">
                   <ul>
                       <li className="info">
                           <h3 className="count">
                               10
                           </h3>
                           <p className="sub--description">
                               лет опыта пассажирских перевозок
                           </p>
                       </li>

                       <li className="info">
                           <h3 className="count">
                               22
                           </h3>
                           <p className="sub--description">
                               буса в автопарке
                           </p>
                       </li>

                       <li className="info">
                           <h3 className="count">
                               900
                           </h3>
                           <p className="sub--description">
                               рейсов каждый месяц
                           </p>
                       </li>

                       <li className="info">
                           <h3 className="count">
                               11000
                           </h3>
                           <p className="sub--description">
                               пассажиров за прошлый месяц
                           </p>
                       </li>

                   </ul>
               </div>
           </div>


       )

    }

    export default Trust