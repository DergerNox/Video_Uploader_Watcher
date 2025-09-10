import React from 'react';
import VideoList from './VideoList';
import VideoUpload from './VideoUpload';

const Dashboard = () => {
  return (
    <div>
      <h1>Dashboard</h1>
      <VideoUpload />
      <VideoList />
    </div>
  );
};

export default Dashboard;
