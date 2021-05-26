import React, {useEffect, useState} from 'react'
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";
import AdminUsers from "./AdminUsers";
import AdminDrivers from "./AdminDrivers";
import AdminAutos from "./AdminAutos";



function AdminPanel(){

    return(
           <>


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


                <button>
                    <Link to={'/autos'} className="help--main--link">
                        <p>autos</p>
                    </Link>
                </button>


                <div className="help-inner">
                    <Switch>
                        <Route component={AdminUsers} path={'/profile'}/>
                        <Route component={AdminDrivers} path={'/drivers'}/>
                        <Route component={AdminAutos} path={'/autos'}/>
                    </Switch>
                </div>
            </Router>

             </>
        )
}


export default AdminPanel
