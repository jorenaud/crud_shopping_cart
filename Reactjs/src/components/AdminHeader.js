import React, { Component } from "react";
import logo from '../images/logo.png';

class AdminHeader extends Component {
  constructor(props) {
    super(props);
    
  }
  
  render() {
    return (
      <header>
        <div className="container">
          <div className="brand">
            <a href="/">
            <img
              className="logo"
              src={logo}
              alt="Logo"
            /></a>
          </div>
        </div>
      </header>
    );
  }
}

export default AdminHeader;
