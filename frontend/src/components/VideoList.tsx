import React, { useEffect, useState } from 'react';
import axios from 'axios';

interface Video {
  id: number;
  title: string;
  description: string;
  file_path: string;
}

const VideoList: React.FC = () => {
  const [videos, setVideos] = useState<Video[]>([]);

  useEffect(() => {
    const fetchVideos = async () => {
      try {
        const response = await axios.get('/backend/api/videos.php');
        setVideos(response.data);
      } catch (error) {
        console.error('Error fetching videos:', error);
      }
    };
    fetchVideos();
  }, []);

  return (
    <div>
      <h2>Videos</h2>
      <ul>
        {videos.map(video => (
          <li key={video.id}>
            <h3>{video.title}</h3>
            <p>{video.description}</p>
            <video controls src={video.file_path} />
          </li>
        ))}
      </ul>
    </div>
  );
};

export default VideoList;
