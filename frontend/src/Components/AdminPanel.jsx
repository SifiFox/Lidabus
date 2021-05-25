import React, {useEffect, useState} from 'react'
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";

import Drivers from "./Drivers";
import AdminUsers from "./AdminUsers";



function AdminPanel(){

    return(
            <Router>
               <button>
                   <Link to={'/profile'} className="help--main--link">
                       <p>users</p>
                   </Link>
               </button>


                <button>
                    <Link to={'/drivers'} className="help--main--link">
                        <p>drivers</p>
                    </Link>
                </button>

                <div className="help-inner">
                    <Switch>
                        <Route component={AdminUsers} path={'/profile'}/>
                        <Route component={Drivers} path={'/drivers'}/>
                    </Switch>
                </div>
            </Router>
        )
}


export default AdminPanel
