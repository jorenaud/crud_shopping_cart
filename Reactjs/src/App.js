import React from "react";
import { Switch, Route } from "react-router-dom";
import Dashboard from "./Dashboard";
import Manage from "./Manage";
import "./scss/style.scss";

class App extends React.Component {
  render() {
    return (
      <Switch>
        <div className="grid-container">
          <main>
            <Route path="/" component={Dashboard} exact />
            <Route path="/admin" component={Manage} />
          </main>
          <footer>All right is reserved.</footer>
        </div>
      </Switch>
    );
  }
}

export default App;