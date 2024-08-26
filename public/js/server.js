const io = require('socket.io')(8000, {
  cors: {
      origin: '*',
  }
});

io.on('connection', socket => {
  console.log('New client connected:', socket.id);

  socket.on('joinRoom', roomCode => {
      socket.join(roomCode);
      console.log(`${socket.id} joined room: ${roomCode}`);
  });

  socket.on('offer', (offer, roomCode) => {
      socket.to(roomCode).emit('offer', offer);
  });

  socket.on('answer', (answer, roomCode) => {
      socket.to(roomCode).emit('answer', answer);
  });

  socket.on('candidate', (candidate, roomCode) => {
      socket.to(roomCode).emit('candidate', candidate);
  });

  socket.on('disconnect', () => {
      console.log('Client disconnected:', socket.id);
  });
});
