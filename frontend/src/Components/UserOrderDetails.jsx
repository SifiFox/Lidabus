import React, {useEffect} from 'react'
import ReactStars from "react-rating-stars-component";
import $ from "jquery";


function UserOrderDetails(props) {

    console.log(props)

    const ratingChanged = (newRating) => {
        console.log(newRating);

        let item = {
            ID_Driver: props.route.ID_Driver,
            Rating: newRating
        }

        let url = "http://lidabusdiplom.by/controllers/rating/setRatingToDriver.php"
        $.ajax({
            xhrFields: {cors: false},
            mode: "no-cors",
            type: 'POST',
            url: url,
            data: {setRating: JSON.stringify(item)},
            dataType: 'json',
        })
    };
   useEffect(() => {

   }, [])
    if(props.shown){
        return (
           <>
               <p>{props.route.Mark}</p>
               <p>{props.route.Cost} BYN</p>
               <ReactStars
                   count={5}
                   onChange={ratingChanged}
                   size={24}
                   activeColor="#ffd700"
               />,
           </>
        )
    }else return null
}


export default UserOrderDetails