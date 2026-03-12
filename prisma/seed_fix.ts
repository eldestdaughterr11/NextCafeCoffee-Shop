const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

async function main() {
  const updates = [
    { id: 16, image: '/images/bananabread.jpg' },
    { id: 18, image: '/images/chocomuffin.jpg' },
    { id: 30, image: '/images/matchalatte.jpg' }
  ];

  console.log('Syncing local image paths for the remaining 3 items...');
  for (const item of updates) {
    await prisma.product.update({
      where: { id: item.id },
      data: { image: item.image }
    });
  }
  console.log('All images are now localized and ready!');
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
